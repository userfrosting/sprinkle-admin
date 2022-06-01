<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Admin\Controller\UserHelper;
use UserFrosting\Sprinkle\Admin\Sprunje\ActivitySprunje;

/**
 * Returns activity history for a single user.
 *
 * This page requires authentication.
 * Request type: GET
 */
class UserActivitySprunje
{
    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Authenticator $authenticator,
        protected ActivitySprunje $sprunje,
        protected UserHelper $userHelper,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param string   $user_name The name of the user to delete, from the URI.
     * @param Request  $request
     * @param Response $response
     */
    public function __invoke(string $user_name, Request $request, Response $response): Response
    {
        // Get the username from the URL
        $user = $this->userHelper->getUser(['user_name' => $user_name]);
        $this->validateAccess($user);

        // GET parameters and pass to Sprunje
        $params = $request->getQueryParams();
        $this->sprunje->setOptions($params);
        $this->sprunje->extendQuery(function ($query) use ($user) {
            return $query->where('user_id', $user->id);
        });

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $this->sprunje->toResponse($response);
    }

    /**
     * Validate access to the page.
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(UserInterface $user): void
    {
        if (!$this->authenticator->checkAccess('view_user_field', [
            'user' => $user,
            'property' => 'activities',
        ])) {
            throw new ForbiddenException();
        }
    }
}