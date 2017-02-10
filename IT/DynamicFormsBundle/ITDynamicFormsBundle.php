<?php

namespace IT\DynamicFormsBundle;

use IT\DynamicFormsBundle\DependencyInjection\CompilerPass\ResponsesAdminPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ITDynamicFormsBundle extends Bundle
{
    
    
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ResponsesAdminPass());

    }


}
