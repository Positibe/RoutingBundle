<?php
/**
 * This file is part of the PositibeLabs Projects.
 *
 * (c) Pedro Carlos Abreu <pcabreus@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Positibe\Bundle\OrmRoutingBundle\Form\Type;

use Positibe\Bundle\OrmRoutingBundle\Builder\RouteBuilder;
use Positibe\Bundle\OrmRoutingBundle\Form\DataTransformer\RoutesToRouteLocaleTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class RoutePermalinkType
 * @package Positibe\Bundle\OrmRoutingBundle\Form\Type
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class RoutePermalinkType extends AbstractType
{
    private $defaultLocale;
    private $routeBuilder;

    public function __construct(RouteBuilder $routeBuilder, $defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;
        $this->routeBuilder = $routeBuilder;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new RoutesToRouteLocaleTransformer(
            $options['content_has_routes'],
            $this->routeBuilder,
            $this->defaultLocale,
            $options['current_locale']
        );

        $builder->addModelTransformer($transformer);
        $builder->add(
            'static_prefix',
            'text',
            array(
                'label' => 'route.form.permalink',
                'translation_domain' => 'PositibeOrmRoutingBundle',
                'required' => false
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Positibe\Bundle\OrmRoutingBundle\Entity\Route',
                'current_locale' => null
            )
        );
        $resolver
            ->setRequired(
                array(
                    'content_has_routes',
                    'current_locale'
                )
            );
        $resolver
            ->addAllowedTypes(
                'content_has_routes',
                'Symfony\Cmf\Component\Routing\RouteReferrersInterface'
            )
            ->addAllowedTypes(
                'current_locale',
                array(
                    'null',
                    'string'
                )
            );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'positibe_route_permalink';
    }

}