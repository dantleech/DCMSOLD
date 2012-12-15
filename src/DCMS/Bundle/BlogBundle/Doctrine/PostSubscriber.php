<?php

namespace DCMS\Bundle\BlogBundle\Doctrine;
use Doctrine\ODM\PHPCR\Event\LifecycleEventArgs;
use Doctrine\ODM\PHPCR\Event\PostFlushEventArgs;
use Doctrine\ODM\PHPCR\Event\LoadClassMetadataEventArgs;
use Doctrine\ODM\PHPCR\Event as Events;
use DCMS\Bundle\BlogBundle\Document\Post;
use DCMS\Bundle\BlogBundle\Entity\Tag;
use DCMS\Bundle\BlogBundle\Entity\TagPost;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\EventSubscriber;


class PostSubscriber implements EventSubscriber
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
        );
    }

    protected function getTagRepo()
    {
        return $this->em->getRepository('DCMS\Bundle\BlogBundle\Entity\Tag');
    }

    protected function purgePostTags($postUuid)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->delete('DCMS\Bundle\BlogBundle\Entity\TagPost', 'tp');
        $qb->where('tp.postUuid = :uuid');
        $q = $qb->getQuery();
        $q->execute(array('uuid' => $postUuid));
    }

    protected function updateTags($args)
    {
        $doc = $args->getDocument();
        $dm = $args->getDocumentManager();
        if ($doc instanceof Post) {
            if (!$doc->getUuid()) {
                $dm->refresh($doc);
            }
            $this->purgePostTags($doc->getUuid());
            $tags = $doc->getTags();
            foreach ($tags as $tag) {
                $tagEnt = $this->getTagRepo()->findOneByName($tag);
                if (!$tagEnt) {
                    $tagEnt = new Tag;
                    $tagEnt->setName($tag);
                    $this->em->persist($tagEnt);
                }
                $this->em->persist($tagEnt);
                $tagEnts[] = $tagEnt;
            }
            $this->em->flush();

            foreach ($tagEnts as $tagEnt) {
                $tagPost = new TagPost;
                $tagPost->setTag($tagEnt);
                $tagPost->setPostUuid($doc->getUuid());
                $this->em->persist($tagPost);
            }
            $this->em->flush();
        }
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->updateTags($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->updateTags($args);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
    }
}
