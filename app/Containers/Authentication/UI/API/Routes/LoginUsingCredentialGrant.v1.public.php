<?php

/**
 * @apiGroup           OAuth2
 * @apiName            LoginCredentialsGrant
 *
 * @api                {post} /v1/oauth/token Login (Client Credentials Grant)
 * @apiDescription     Login Users using their username and passwords. (For Third-Party Clients).
 *                     You must have client ID and secret first. You can generate them by creating new Client in our Web App.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {String}  client_id
 * @apiParam           {String}  client_secret
 * @apiParam           {String}  grant_type must be `client_credentials`
 * @apiParam           {String}  [scope] you can leave it empty
 *
 * @apiUse             AuthLoginCredentialsSuccessResponse
 */

// Implementation in the Laravel Passport package
