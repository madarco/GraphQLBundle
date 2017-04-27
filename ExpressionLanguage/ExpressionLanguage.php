<?php

/*
 * This file is part of the OverblogGraphQLBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\GraphQLBundle\ExpressionLanguage;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage as BaseExpressionLanguage;

class ExpressionLanguage extends BaseExpressionLanguage
{
    use ContainerAwareTrait;

    public function __construct(CacheItemPoolInterface $parser = null, array $providers = [])
    {
        // prepend the default provider to let users override it easily
        array_unshift($providers, new ConfigExpressionProvider());
        array_unshift($providers, new AuthorizationExpressionProvider());

        parent::__construct($parser, $providers);
    }

    public function compile($expression, $names = [])
    {
        $names[] = 'container';
        $names[] = 'request';
        $names[] = 'security.token_storage';
        $names[] = 'token';
        $names[] = 'user';

        return parent::compile($expression, $names);
    }
}
