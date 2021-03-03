<?php

namespace App\Ship\Core\Loaders;

use App\Ship\Core\Foundation\Facades\Apiato;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class RoutesLoaderTrait.
 */
trait RoutesLoaderTrait
{
    /**
     * Register all the containers routes files in the framework.
     */
    public function runRoutesAutoLoader(): void
    {
        $containersPaths     = Apiato::getContainersPaths();
        $containersNamespace = Apiato::getContainersNamespace();

        foreach ($containersPaths as $containerPath) {
            $this->loadApiContainerRoutes($containerPath, $containersNamespace);
            $this->loadWebContainerRoutes($containerPath, $containersNamespace);
        }
    }

    /**
     * Register the Containers API routes files.
     *
     * @param string $containerPath
     * @param string $containersNamespace
     *
     * @return string|void
     */
    private function loadApiContainerRoutes($containerPath, $containersNamespace)
    {
        // build the container api routes path
        $apiRoutesPath = $containerPath . '/UI/API/Routes';
        // build the namespace from the path
        $controllerNamespace = $containersNamespace . '\\Containers\\' . basename($containerPath) . '\\UI\API\Controllers';

        if (File::isDirectory($apiRoutesPath)) {
            $files = File::allFiles($apiRoutesPath);
            $files = Arr::sort($files, function (SplFileInfo $file): string {
                return $file->getFilename();
            });
            foreach ($files as $file) {
                $this->loadApiRoute($file, $controllerNamespace);
            }
        }
    }

    /**
     * Register the Containers WEB routes files.
     *
     * @param string $containerPath
     * @param string $containersNamespace
     *
     * @return void
     */
    private function loadWebContainerRoutes($containerPath, $containersNamespace): void
    {
        // build the container web routes path
        $webRoutesPath = $containerPath . '/UI/WEB/Routes';
        // build the namespace from the path
        $controllerNamespace = $containersNamespace . '\\Containers\\' . basename($containerPath) . '\\UI\WEB\Controllers';

        if (File::isDirectory($webRoutesPath)) {
            $files = File::allFiles($webRoutesPath);
            $files = Arr::sort($files, function (SplFileInfo $file): string {
                return $file->getFilename();
            });
            foreach ($files as $file) {
                $this->loadWebRoute($file, $controllerNamespace);
            }
        }
    }

    /**
     * @param SplFileInfo $file
     * @param string      $controllerNamespace
     *
     * @return void
     */
    private function loadWebRoute($file, $controllerNamespace): void
    {
        $routeGroupArray = $this->getAdminRouteGroup($file, $controllerNamespace);

        $this->createRouteGroup($file, $routeGroupArray);
    }

    /**
     * @param SplFileInfo $file
     * @param string      $controllerNamespace
     *
     * @return void
     */
    private function loadApiRoute($file, $controllerNamespace): void
    {
        $routeGroupArray = $this->getApiRouteGroup($file, $controllerNamespace);

        $this->createRouteGroup($file, $routeGroupArray);
    }

    /**
     * @param SplFileInfo $file
     * @param array       $routeGroupArray
     *
     * @return void
     */
    private function createRouteGroup($file, $routeGroupArray): void
    {
        Route::group($routeGroupArray, function (Router $router) use ($file) {
            /** @psalm-suppress UnresolvableInclude dynamic include, psalm cant resolve it */
            require $file->getPathname();
        });
    }

    /**
     * @param string|SplFileInfo $endpointFileOrPrefixString
     * @param null|string        $controllerNamespace
     *
     * @return array
     */
    public function getApiRouteGroup($endpointFileOrPrefixString, $controllerNamespace = null)
    {
        return [
            'namespace'  => $controllerNamespace,
            'middleware' => $this->getMiddlewares(),
            'domain'     => $this->getApiDomain(),
            // if $endpointFileOrPrefixString is a file then get the version name from the file name, else if string use that string as prefix
            'prefix'     => is_string($endpointFileOrPrefixString) ? $endpointFileOrPrefixString : $this->getApiVersionPrefix($endpointFileOrPrefixString),
        ];
    }

    /**
     * @param SplFileInfo $file
     * @param string|null $controllerNamespace
     *
     * @return array
     */
    public function getAdminRouteGroup($file, $controllerNamespace = null)
    {
        return [
            'namespace'  => $controllerNamespace,
            'middleware' => ['web'],
        ];
    }

    /**
     * @return string
     */
    private function getApiDomain()
    {
        return parse_url($this->getApiUrl(), PHP_URL_HOST);
    }

    /**
     * @return string
     */
    private function getApiUrl()
    {
        return config('apiato.api.url');
    }

    /**
     * @return string
     */
    private function getAdminPrefix()
    {
        return config('apiato.admin.prefix');
    }

    /**
     * @param SplFileInfo $file
     *
     * @return string
     */
    private function getApiVersionPrefix($file)
    {
        return Apiato::getApiPrefix() . (config('apiato.api.enable_version_prefix') ? $this->getRouteFileVersionFromFileName($file) : '');
    }

    /**
     * @return array
     */
    private function getMiddlewares()
    {
        return array_filter([
            'api',
            $this->getRateLimitMiddleware(), // returns NULL if feature disabled. Null will be removed form the array.
        ]);
    }

    /**
     * @return null|string
     */
    private function getRateLimitMiddleware()
    {
        $rateLimitMiddleware = null;

        if (config('apiato.api.throttle.enabled')) {
            $rateLimitMiddleware = 'throttle:' . config('apiato.api.throttle.attempts') . ',' . config('apiato.api.throttle.expires');
        }

        return $rateLimitMiddleware;
    }

    /**
     * Configure the rate limiters for the API application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        if (config('auth.login.throttle.enabled')) {
            RateLimiter::for('login', function (HttpRequest $request) {
                $ip = $request->ip() ?? '';

                return Limit::perMinute(config('auth.login.throttle.attempts'))
                    ->by(Str::lower($request->input('email')) . '|' . $ip);
            });
        }
    }

    /**
     * @param SplFileInfo $file
     *
     * @return string
     */
    private function getRouteFileVersionFromFileName($file)
    {
        $fileNameWithoutExtension = $this->getRouteFileNameWithoutExtension($file);

        $fileNameWithoutExtensionExploded = explode('.', $fileNameWithoutExtension);

        end($fileNameWithoutExtensionExploded);

        $apiVersion = prev($fileNameWithoutExtensionExploded); // get the array before the last one

        // Skip versioning the API's root route
        if ($apiVersion === 'ApisRoot') {
            $apiVersion = '';
        }

        return $apiVersion;
    }

    /**
     * @param SplFileInfo $file
     *
     * @return string
     */
    private function getRouteFileNameWithoutExtension(SplFileInfo $file)
    {
        $fileInfo = pathinfo($file->getFileName());

        return $fileInfo['filename'];
    }
}
