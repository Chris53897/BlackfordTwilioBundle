<?php
namespace Blackford\TwilioBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This file is part of the BlackfordTwilioBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Matthew Blackford <matthew.blackford@gmail.com>
 * @author Fridolin Koch <info@fridokoch.de>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('twilio');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->scalarNode('username')->isRequired()->end()
            ->scalarNode('password')->isRequired()->end()
            ->scalarNode('accountSid')->defaultNull()->end()
            ->scalarNode('region')->defaultNull()->end()
            ->end();

        return $treeBuilder;
    }
}
