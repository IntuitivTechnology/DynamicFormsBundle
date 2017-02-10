<?php
/**
 * Created by PhpStorm.
 * User: pvassoilles
 * Date: 09/02/17
 * Time: 16:12
 */

namespace IT\DynamicFormsBundle\DependencyInjection\CompilerPass;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use IT\DynamicFormsBundle\Admin\FormResponseAdmin;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Tests\Compiler\MultipleArguments;

class ResponsesAdminPass implements CompilerPassInterface
{

    /**
     * Injects Sonata Admin services for each dynamic form
     *
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function process(ContainerBuilder $container)
    {

        try {

            // Setting up a Doctrine EntityManager for getting Form class metadatas
            $config = Setup::createAnnotationMetadataConfiguration(array(
                __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Entity'
            ), false, null, null, false);
            $dbParams = array(
                'driver'   => 'pdo_mysql',
                'user'     => $container->getParameter('database_user'),
                'password' => $container->getParameter('database_password'),
                'dbname'   => $container->getParameter('database_name'),
            );
            $entityManager = EntityManager::create($dbParams, $config);
            $classMetadata = $entityManager->getClassMetadata('IT\DynamicFormsBundle\Entity\Form');

            // Connect to database and get all form names
            $db = new \PDO(sprintf('mysql:host=%s;dbname=%s', $container->getParameter('database_host'), $container->getParameter('database_name')), $container->getParameter('database_user'), $container->getParameter('database_password'));
            $sql = sprintf('SELECT DISTINCT %s FROM %s', $classMetadata->getColumnName('name'), $classMetadata->getTableName());
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll(\PDO::FETCH_COLUMN);

            // Foreach form name, create a Sonata Admin service
            foreach ($result as $formName) {

                $container
                    ->register('sonata.admin.form_response.' . strtolower($formName), 'IT\DynamicFormsBundle\Admin\FormResponseAdmin')
                    ->setArguments(array(
                        null,
                        'IT\DynamicFormsBundle\Entity\FormResponse',
                        null,
                    ))
                    ->addTag('sonata.admin', array(
                        'manager_type' => 'orm',
                        'group' => 'Réponses aux formulaires',
                        'label' => ucfirst($formName),
                        'icon' => 'fa fa-cogs',
                    ))
                    ->addMethodCall('setName', array(
                        $formName,
                    ))
                ;

            }

        } catch (\Exception $e) {
            throw $e;
        }

    }
}