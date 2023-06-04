<?php

declare(strict_types=1);

namespace App\DependencyInjection\Compiler;

use App\Shared\Infrastructure\Symfony\Translation\TranslationManagerInterface;
use App\Shared\Infrastructure\Symfony\Translation\Translator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class TranslatorCompilerPass implements CompilerPassInterface
{
    public function __construct(
        private string $translatorServiceId = 'translator.default',
        private string $readerServiceId = 'translation.reader',
        private string $loaderTag = 'translation.loader',
        private string $debugCommandServiceId = 'console.command.translation_debug',
        private string $updateCommandServiceId = 'console.command.translation_update'
    ) {
    }

    public function process(ContainerBuilder $container): void
    {
        $loaders = [];
        $loaderRefs = [];

        foreach ($container->findTaggedServiceIds($this->loaderTag, true) as $id => $attributes) {
            $loaderRefs[$id] = new Reference($id);
            $loaders[$id][] = $attributes[0]['alias'];
            if (isset($attributes[0]['legacy-alias'])) {
                $loaders[$id][] = $attributes[0]['legacy-alias'];
            }
        }

        if ($container->hasDefinition($this->readerServiceId)) {
            $definition = $container->getDefinition($this->readerServiceId);
            foreach ($loaders as $id => $formats) {
                foreach ($formats as $format) {
                    $definition->addMethodCall('addLoader', [$format, $loaderRefs[$id]]);
                }
            }
        }

        $definition = $container->findDefinition($this->translatorServiceId);

        $definition
            ->setClass(Translator::class)
            ->replaceArgument(0, '')
            ->replaceArgument(1, $definition->getArgument(1))
            ->replaceArgument(2, $definition->getArgument(4)["cache_dir"])
            ->replaceArgument(3, $definition->getArgument(4)["debug"])
            ->replaceArgument(4, $definition->getArgument(4)["resource_files"])
            ->addMethodCall("setTranslationManager", [new Reference(TranslationManagerInterface::class)])
        ;

        if (!$container->hasParameter('twig.default_path')) {
            return;
        }

        if ($container->hasDefinition($this->debugCommandServiceId)) {
            $container->getDefinition($this->debugCommandServiceId)->replaceArgument(4, $container->getParameter('twig.default_path'));
        }

        if ($container->hasDefinition($this->updateCommandServiceId)) {
            $container->getDefinition($this->updateCommandServiceId)->replaceArgument(5, $container->getParameter('twig.default_path'));
        }
    }
}