<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace LaravelKeenIO;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LaravelKeenIO\Exceptions\ConfigurationException;
use LaravelKeenIO\Options\ModuleOptions;
use LaravelKeenIO\Services\KeenIOService;

class LaravelKeenIOProvider extends ServiceProvider
{
    /**
     * Boot
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('keen-io.php'),
        ], 'config');
    }

    /**
     * Register package
     */
    public function register()
    {
        $this->mergeConfig();

        // Register services
        $this->registerServices();
    }

    /**
     * Merge config
     */
    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php',
            'keen-io'
        );
    }

    /**
     * Register services
     */
    protected function registerServices()
    {
        $this->app->bind(KeenIOService::class, function (Application $app) {
            if (!$config = config('keen-io')) {
                throw new ConfigurationException('Please run \'artisan vendor:publish\' to publish the config file');
            }

            $moduleOptions = new ModuleOptions($config);

            return new KeenIOService($moduleOptions);
        });
    }
}
