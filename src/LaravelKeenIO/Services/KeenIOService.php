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

namespace LaravelKeenIO\Services;

use KeenIO\Client\KeenIOClient;
use LaravelKeenIO\Exceptions\ConfigurationException;
use LaravelKeenIO\Options\ModuleOptions;
use LaravelKeenIO\Options\Project;

class KeenIOService implements KeenIOServiceInterface
{
    const DEFAULT_VERSION = '3.0';

    /** @var ModuleOptions */
    protected $moduleOptions;

    /**
     * KeenIOService constructor.
     * @param ModuleOptions $moduleOptions
     */
    public function __construct(ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @param null $project
     * @return KeenIOClient
     * @throws ConfigurationException
     */
    public function client($project = null)
    {
        $moduleOptions = $this->moduleOptions;

        if (is_null($project)) {
            $project = $moduleOptions->get('default');
        }

        $projects = $this->getProjects();

        if (!isset($projects[$project])) {
            throw new ConfigurationException(sprintf(
                'No configuration found for \'%s\'',
                $project
            ));
        }

        $config = $projects[$project];

        // Version
        if (is_null($config->get('version'))) {
            $config->set('version', self::DEFAULT_VERSION);
        }

        return KeenIOClient::factory([
            'projectId' => $config->get('projectId'),
            'writeKey'  => $config->get('writeKey'),
            'readKey'   => $config->get('readKey'),
            'version'   => $config->get('version'),
        ]);
    }

    /**
     * Get projects
     *
     * @return array|\LaravelKeenIO\Options\Project[]
     */
    protected function getProjects()
    {
        /** @var Project[]|array $projects */
        $projects = [];

        foreach ($this->moduleOptions->get('projects') as $title => $project) {
            $projects[$title] = new Project($project);
        }

        return $projects;
    }
}
