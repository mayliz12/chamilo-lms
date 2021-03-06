<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Framework;

use Chamilo\CoreBundle\Component\Editor\Editor;
use Chamilo\CoreBundle\Hook\Interfaces\HookEventInterface;
use Chamilo\CoreBundle\Repository\AccessUrlRepository;
use Chamilo\CoreBundle\Repository\CourseCategoryRepository;
use Chamilo\CoreBundle\Repository\CourseRepository;
use Chamilo\CoreBundle\Repository\IllustrationRepository;
use Chamilo\CoreBundle\ToolChain;
use Chamilo\CourseBundle\Repository\CDocumentRepository;
use Chamilo\CourseBundle\Repository\CExerciseCategoryRepository;
use Chamilo\CourseBundle\Repository\CLpCategoryRepository;
use Chamilo\CourseBundle\Repository\CLpRepository;
use Chamilo\CourseBundle\Repository\CQuizQuestionCategoryRepository;
use Chamilo\CourseBundle\Repository\CQuizQuestionRepository;
use Chamilo\CourseBundle\Repository\CQuizRepository;
use Chamilo\CourseBundle\Repository\CStudentPublicationAssignmentRepository;
use Chamilo\CourseBundle\Repository\CStudentPublicationCommentRepository;
use Chamilo\CourseBundle\Repository\CStudentPublicationRepository;
use Chamilo\PageBundle\Entity\Page;
use Chamilo\SettingsBundle\Manager\SettingsManager;
use Chamilo\UserBundle\Repository\UserRepository;
use Sonata\PageBundle\Entity\SiteManager;
use Sonata\UserBundle\Entity\UserManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Role\RoleHierarchy;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class Container
 * This class is a way to access Symfony2 services in legacy Chamilo code.
 */
class Container
{
    /**
     * @var ContainerInterface
     */
    public static $container;
    public static $session;
    public static $request;
    public static $configuration;
    public static $environment;
    public static $urlGenerator;
    public static $checker;
    /** @var TranslatorInterface */
    public static $translator;
    public static $mailer;
    public static $template;

    public static $rootDir;
    public static $logDir;
    public static $tempDir;
    public static $dataDir;
    public static $courseDir;
    public static $assets;
    public static $htmlEditor;
    public static $twig;
    public static $roles;
    /** @var string */
    public static $legacyTemplate = '@ChamiloTheme/Layout/layout_one_col.html.twig';
    private static $settingsManager;
    private static $userManager;
    private static $siteManager;

    /**
     * @param ContainerInterface $container
     */
    public static function setContainer($container)
    {
        self::$container = $container;
    }

    /**
     * @param string $parameter
     *
     * @return mixed
     */
    public static function getParameter($parameter)
    {
        if (self::$container->hasParameter($parameter)) {
            return self::$container->getParameter($parameter);
        }

        return false;
    }

    /**
     * @return string
     */
    public static function getEnvironment()
    {
        return self::$container->get('kernel')->getEnvironment();
    }

    /**
     * @return RoleHierarchy
     */
    public static function getRoles()
    {
        return self::$container->get('security.role_hierarchy');
    }

    /**
     * @return string
     */
    public static function getLogDir()
    {
        return self::$container->get('kernel')->getLogDir();
    }

    /**
     * @return string
     */
    public static function getCacheDir()
    {
        return self::$container->get('kernel')->getCacheDir().'/';
    }

    /**
     * @return string
     */
    public static function getProjectDir()
    {
        if (isset(self::$container)) {
            return self::$container->get('kernel')->getProjectDir().'/';
        }

        return str_replace('\\', '/', realpath(__DIR__.'/../../../')).'/';
    }

    /**
     * @return string
     */
    public static function isInstalled()
    {
        return self::$container->get('kernel')->isInstalled();
    }

    /**
     * @return \Twig_Environment
     */
    public static function getTwig()
    {
        return self::$container->get('twig');
    }

    /**
     * @return \Symfony\Bundle\TwigBundle\TwigEngine
     */
    public static function getTemplating()
    {
        return self::$container->get('templating');
    }

    /**
     * @return Editor
     */
    public static function getHtmlEditor()
    {
        return self::$container->get('chamilo_core.html_editor');
    }

    /**
     * @return object|Request
     */
    public static function getRequest()
    {
        if (self::$container === null) {
            return null;
        }

        if (!empty(self::$request)) {
            return self::$request;
        }

        return self::$container->get('request_stack');
    }

    /**
     * @param Request $request
     */
    public static function setRequest($request)
    {
        self::$request = $request;
    }

    /**
     * @return Session|false
     */
    public static function getSession()
    {
        if (self::$container && self::$container->has('session')) {
            return self::$container->get('session');
        }

        return false;
    }

    /**
     * @return AuthorizationChecker
     */
    public static function getAuthorizationChecker()
    {
        return self::$container->get('security.authorization_checker');
    }

    /**
     * @return object|\Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage
     */
    public static function getTokenStorage()
    {
        return self::$container->get('security.token_storage');
    }

    /**
     * @return TranslatorInterface
     */
    public static function getTranslator()
    {
        if (isset(self::$translator)) {
            return self::$translator;
        }

        if (self::$container) {
            return self::$container->get('translator');
        }

        return false;
    }

    public static function getMailer()
    {
        return self::$container->get('Symfony\Component\Mailer\Mailer');
    }

    /**
     * @return \Elao\WebProfilerExtraBundle\TwigProfilerEngine
     */
    public static function getTemplate()
    {
        return self::$container->get('templating');
    }

    /**
     * @return SettingsManager
     */
    public static function getSettingsManager()
    {
        return self::$settingsManager;
    }

    /**
     * @param SettingsManager $manager
     */
    public static function setSettingsManager($manager)
    {
        self::$settingsManager = $manager;
    }

    /**
     * @return \Chamilo\CourseBundle\Manager\SettingsManager
     */
    public static function getCourseSettingsManager()
    {
        return self::$container->get('Chamilo\CourseBundle\Manager\SettingsManager');
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public static function getEntityManager()
    {
        return \Database::getManager();
    }

    /**
     * @return UserManager
     */
    public static function getUserManager()
    {
        return self::$userManager;
    }

    /**
     * @return CDocumentRepository
     */
    public static function getDocumentRepository()
    {
        return self::$container->get('Chamilo\CourseBundle\Repository\CDocumentRepository');
    }

    /**
     * @return CQuizRepository
     */
    public static function getExerciseRepository()
    {
        return self::$container->get('Chamilo\CourseBundle\Repository\CQuizRepository');
    }

    /**
     * @return CExerciseCategoryRepository
     */
    public static function getExerciseCategoryRepository()
    {
        return self::$container->get('Chamilo\CourseBundle\Repository\CExerciseCategoryRepository');
    }

    /**
     * @return CQuizQuestionRepository
     */
    public static function getQuestionRepository()
    {
        return self::$container->get('Chamilo\CourseBundle\Repository\CQuizQuestionRepository');
    }

    /**
     * @return CQuizQuestionCategoryRepository
     */
    public static function getQuestionCategoryRepository()
    {
        return self::$container->get('Chamilo\CourseBundle\Repository\CQuizQuestionCategoryRepository');
    }

    /**
     * @return CLpRepository
     */
    public static function getLpRepository()
    {
        return self::$container->get('Chamilo\CourseBundle\Repository\CLpRepository');
    }

    /**
     * @return CLpCategoryRepository
     */
    public static function getLpCategoryRepository()
    {
        return self::$container->get('Chamilo\CourseBundle\Repository\CLpCategoryRepository');
    }

    /**
     * @return AccessUrlRepository
     */
    public static function getAccessUrlRepository()
    {
        return self::$container->get('Chamilo\CoreBundle\Repository\AccessUrlRepository');
    }

    /**
     * @return CourseRepository
     */
    public static function getCourseRepository()
    {
        return self::$container->get('Chamilo\CoreBundle\Repository\CourseRepository');
    }

    /**
     * @return UserRepository
     */
    public static function getUserRepository()
    {
        return self::$container->get('Chamilo\UserBundle\Repository\UserRepository');
    }

    /**
     * @return CourseCategoryRepository|object|null
     */
    public static function getCourseCategoryRepository()
    {
        return self::$container->get('Chamilo\CoreBundle\Repository\CourseCategoryRepository');
    }

    /**
     * @return IllustrationRepository
     */
    public static function getIllustrationRepository()
    {
        return self::$container->get('Chamilo\CoreBundle\Repository\IllustrationRepository');
    }

    /**
     * @return CStudentPublicationRepository
     */
    public static function getStudentPublicationRepository()
    {
        return self::$container->get('Chamilo\CourseBundle\Repository\CStudentPublicationRepository');
    }

    /**
     * @return CStudentPublicationAssignmentRepository
     */
    public static function getStudentPublicationAssignmentRepository()
    {
        return self::$container->get('Chamilo\CourseBundle\Repository\CStudentPublicationAssignmentRepository');
    }

    /**
     * @return CStudentPublicationCommentRepository
     */
    public static function getStudentPublicationCommentRepository()
    {
        return self::$container->get('Chamilo\CourseBundle\Repository\CStudentPublicationCommentRepository');
    }

    /**
     * @param $manager UserManager
     */
    public static function setUserManager($manager)
    {
        self::$userManager = $manager;
    }

    /**
     * @return SiteManager
     */
    public static function getSiteManager()
    {
        return self::$siteManager;
    }

    /**
     * @param $manager UserManager
     */
    public static function setSiteManager($manager)
    {
        self::$siteManager = $manager;
    }

    /**
     * @return \Sonata\UserBundle\Entity\GroupManager
     */
    public static function getGroupManager()
    {
        return self::$container->get('fos_user.group_manager');
    }

    /**
     * @return \Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher
     */
    public static function getEventDispatcher()
    {
        return self::$container->get('event_dispatcher');
    }

    /**
     * @return \Symfony\Component\Form\FormFactory
     */
    public static function getFormFactory()
    {
        return self::$container->get('form.factory');
    }

    /**
     * @param string $message
     * @param string $type    error|success|warning|danger
     */
    public static function addFlash($message, $type = 'success')
    {
        $session = self::getSession();
        $session->getFlashBag()->add($type, $message);
    }

    /**
     * @return object|\Symfony\Cmf\Component\Routing\ChainRouter
     */
    public static function getRouter()
    {
        return self::$container->get('router');
    }

    /**
     * @return ToolChain
     */
    public static function getToolChain()
    {
        return self::$container->get(ToolChain::class);
    }

    /**
     * @param ContainerInterface $container
     * @param bool               $setSession
     */
    public static function setLegacyServices($container, $setSession = true)
    {
        \Database::setConnection($container->get('doctrine.dbal.default_connection'));
        $em = $container->get('doctrine.orm.entity_manager');
        \Database::setManager($em);
        \CourseManager::setEntityManager($em);

        self::setSettingsManager($container->get('chamilo.settings.manager'));
        self::setUserManager($container->get('fos_user.user_manager'));
        self::setSiteManager($container->get('sonata.page.manager.site'));

        \CourseManager::setCourseSettingsManager($container->get('Chamilo\CourseBundle\Manager\SettingsManager'));
        // Setting course tool chain (in order to create tools to a course)
        \CourseManager::setToolList($container->get(ToolChain::class));

        if ($setSession) {
            self::$session = $container->get('session');
        }
    }

    /**
     * Gets a sonata page.
     *
     * @param string $slug
     *
     * @return Page
     */
    public static function getPage($slug)
    {
        $container = self::$container;
        /*$siteSelector = $container->get('sonata.page.site.selector');
        $site = $siteSelector->retrieve();*/
        $siteManager = $container->get('sonata.page.manager.site');
        $request = Container::getRequest();
        $page = null;
        if ($request) {
            $host = $request->getHost();
            $criteria = [
                'locale' => $request->getLocale(),
                'host' => $host,
            ];
            $site = $siteManager->findOneBy($criteria);

            $pageManager = $container->get('sonata.page.manager.page');
            // Parents only of homepage
            $criteria = ['site' => $site, 'enabled' => true, 'slug' => $slug];
            /** @var Page $page */
            $page = $pageManager->findOneBy($criteria);

            return $page;
        }

        return $page;
    }

    /**
     * @throws \Exception
     */
    public static function instantiateHook(string $class): HookEventInterface
    {
        return self::$container->get('chamilo_core.hook_factory')->build($class);
    }
}
