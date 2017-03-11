<?php
/**
 * This file is part of the PositibeLabs Projects.
 *
 * (c) Pedro Carlos Abreu <pcabreus@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Positibe\Bundle\OrmRoutingBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\MappingException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;


/**
 * Class ContentLoader
 * @package Positibe\Bundle\OrmRoutingBundle\Entity
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class ContentLoader
{
    /**
     * @param Route $route
     * @param $manager
     * @param null $locale
     */
    public static function loadContent($route, $manager, $locale = null)
    {
        if ($route instanceof Route &&
            $route->getContentClass() !== null &&
            $repository = self::getContentRepositoryByRoute($route, $manager, $locale)
        ) {
            if ($content = $repository->findOneByRoutes($route)) {
                $route->setContent($content);
            } else {
                throw new RouteNotFoundException(
                    "The route (" . $route->getName() . ") was found but has not a valid content."
                );
            }

        }
    }

    /**
     * @param Route $route
     * @param EntityManager $manager
     * @return null|HasRoutesRepositoryInterface
     */
    public static function getContentRepositoryByRoute(Route $route, EntityManager $manager, $locale)
    {
        try {
            $repository = $manager->getRepository($route->getContentClass());
        } catch (MappingException $e) {
            return null;
        }
        if (method_exists($repository, 'setLocale')) {
            $repository->setLocale($locale);
        }

        return $repository instanceof HasRoutesRepositoryInterface ? $repository : null;
    }
} 