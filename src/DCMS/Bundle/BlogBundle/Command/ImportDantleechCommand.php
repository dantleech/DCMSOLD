<?php

namespace DCMS\Bundle\BlogBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use DCMS\Bundle\BlogBundle\Document\Post;
use DCMS\Bundle\BlogBundle\Document\BlogEndpoint;
use DCMS\Bundle\CoreBundle\Document\Folder;

class ImportDantleechCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('dcms:blog:importdantleech');
        $this->setDescription('Script to import my website');
    }

    protected function getDTLConnection()
    {
        $pdo = new \PDO('mysql:dbname=dantleech2;host=localhost', 'root', '');
        return $pdo;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->dm = $this->getContainer()->get('doctrine_phpcr.odm.default_document_manager');
        $this->db = $this->getDTLConnection();
        $this->em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $this->output = $output;
        $this->blog = $this->getBlog();
        $this->importBlogs();
    }

    protected function getBlog()
    {
        $blog = $this->dm->find(null, '/sites/dantleech.com/endpoints/blog');
        if (null === $blog) {
            $this->output->writeln('Creating new blog endpoiint');
            $blog = new BlogEndpoint;
            $blog->setTitle('Blog');
            $blog->setParent($this->dm->find(null, '/sites/dantleech.com/endpoints'));
            $this->dm->persist($blog);
            $this->dm->flush();
        }

        $folder = $this->dm->find(null, '/sites/dantleech.com/endpoints/blog/posts');
        if (!$folder) {
            $folder = new Folder;
            $folder->setNodeName('Posts');
            $folder->setParent($blog);
            $this->dm->persist($folder);
            $this->dm->flush();
        }

        return $folder;
    }

    protected function importBlogs()
    {
        $sql = "SELECT * FROM blog";
        $res = $this->db->query($sql);

        foreach ($this->blog->getChildren() as $child) {
            $this->dm->remove($child);
        }

        $this->dm->flush();

        while ($row = $res->fetch(\PDO::FETCH_ASSOC)) {
            $this->output->writeln('<info>Importing : '.$row['title'].'</info>');
            $post = new Post;
            $post->setTitle($row['title']);
            $post->setBody($row['body']);
            $post->setCreatedAt(new \DateTime($row['created_at']));
            $post->setParent($this->blog);
            $tags = $this->getTags($row['id']);
            $post->setTags($tags);
            $post->setBlog($this->blog->getParent());
            $this->dm->persist($post);
        }
        $this->dm->flush();
    }

    protected function getTags($postId)
    {
        $sql = "SELECT name FROM tag t LEFT JOIN tagging tb ON t.id = tb.tag_id WHERE tb.taggable_id = ".$postId;
        $stmt = $this->db->query($sql);
        $tags = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tags[] = $row['name'];
        }
        return $tags;
    }
}
