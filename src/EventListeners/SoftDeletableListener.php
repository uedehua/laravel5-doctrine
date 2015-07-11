<?php

namespace UeDehua\LaravelDoctrine\EventListeners;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class SoftDeletableListener
{

    public function onFlush(OnFlushEventArgs $event)
    {
        $entityManager = $event->getEntityManager();
        $unitOfWork = $entityManager->getUnitOfWork();
        foreach ($unitOfWork->getScheduledEntityDeletions() as $entity) {
            if ($this->isSoftDeletable($entity)) {
                $metadata = $entityManager->getClassMetadata(get_class($entity));
                $oldDeletedAt = $metadata->getFieldValue($entity, 'deletedAt');
                if ($oldDeletedAt instanceof \DateTime) {
                    continue;
                }
                $now = new \DateTime();
                $metadata->setFieldValue($entity, 'deletedAt', $now);
                $entityManager->persist($entity);
                $unitOfWork->propertyChanged($entity, 'deletedAt', $oldDeletedAt, $now);
                $unitOfWork->scheduleExtraUpdate($entity, [
                    'deletedAt' => [$oldDeletedAt, $now]
                ]);
            }
        }
    }

    private function isSoftDeletable($entity)
    {
        return array_key_exists('UeDehua\LaravelDoctrine\Traits\SoftDeletes', class_uses($entity));
    }

}
