<?php

namespace DCMS\Bundle\BlogBundle\DataFixtures\PHPCR;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use DCMS\Bundle\CoreBundle\Document\Folder;
use DCMS\Bundle\BlogBundle\Document\Post;
use DCMS\Bundle\BlogBundle\Document\BlogEndpoint;

class LoadBlogData implements FixtureInterface, DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            'DCMS\Bundle\CoreBundle\DataFixtures\PHPCR\LoadSiteData',
        );
    }

    public function load(ObjectManager $manager)
    {
        $epRoot = $manager->find(null, '/sites/dantleech.com/endpoints');

        $ep = new BlogEndpoint;
        $ep->setParent($epRoot);
        $ep->setTitle('Dans Blog');
        $folder = new Folder;
        $folder->setNodeName('posts');
        $folder->setParent($ep);
        $ep->setPostsFolder($folder);

        $manager->persist($folder);
        $manager->persist($ep);

        for ($i = 1; $i <= 20; $i++) {
            $p = new Post;
            $p->setTitle('Post '.$i);
            $p->setDate(new \DateTime());
            $p->setBody($this->getWords());
            $p->setParent($folder);
            $p->setBlog($ep);
            $p->setTags($this->getTags());
            $manager->persist($p);
        }


        // add a test tag for the functional tests
        $p->setTags(array('test'));
        $manager->persist($p);

        $manager->flush();

        $ep = new BlogEndpoint;
        $ep->setParent($epRoot);
        $ep->setTitle('Bicycle tour 2013');
        $folder = new Folder;
        $folder->setNodeName('logs');
        $folder->setParent($ep);
        $ep->setPostsFolder($folder);
        $manager->persist($ep);

        for ($i = 1; $i <= 20; $i++) {
            $p = new Post;
            $p->setTitle('Travel post '.$i);
            $p->setDate(new \DateTime());
            $p->setBody($this->getWords());
            $p->setParent($folder);
            $p->setBlog($ep);
            $p->setTags($this->getTags());
            $manager->persist($p);
        }
        $manager->flush();
    }

    protected function getTags()
    {
        $tags = array(
            'DropBox',
            'XMPP',
            'android',
            'apache',
            'archos',
            'audacious',
            'awesome',
            'bash',
            'bootstrap',
            'bristol',
            'diagramming',
            'doctrine',
            'doctrine2',
            'git',
            'gloucester',
            'graphs',
            'gt540',
            'jack',
            'javascript',
            'mail',
            'manchester',
            'mapdroyd',
            'markdown',
            'mongodb',
            'paris',
            'php',
            'profiling',
            'projectm',
            'running',
            'scripting',
            'sed',
            'software',
            'design',
            'ssh',
            'sup',
            'symfony',
            'symfony2',
            'thonon',
            'touring',
            'trainer',
            'travel',
            'twig',
            'ubnutu',
            'velo',
            'vim',
            'weymouth',
            'workflow',
            'xdebug',
            'xml',
            'ylly',
            'yprox',
        );

        $nbTags = rand(2,5);
        $sTags = array();
        for ($i = 0; $i < $nbTags; $i ++) {
            $sTags[] = $tags[rand(0, (count($tags) - 1))];
        }

        return $sTags;
    }

    protected function getWords()
    {
        $projectNim = <<<HERE
Project Nim was an attempt to go further than Project Washoe. Terrace and his colleagues aimed to use more rigorous experimental techniques, and the intellectual discipline of the experimental analysis of behavior, so that the linguistic abilities of the apes could be put on a more secure footing. Roger Fouts wrote: Since 98.7% of the DNA in humans and chimps is identical, some scientists (but not Noam Chomsky) believed that a chimp raised in a human family, and using ASL (American Sign Language), would shed light on the way language is acquired and used by humans. Project Nim, headed by behavioral psychologist Herbert Terrace at Columbia University, was conceived in the early 1970s as a challenge to Chomsky's thesis that only humans have language.[4] Attention was particularly focused on Nim's ability to make different responses to different sequences of signs and to emit different sequences in order to communicate different meanings. However, the results, according to Fouts, were not as impressive as had been reported from the Washoe project. Terrace, however, was skeptical of Project Washoe and, according to the critics, went to great lengths to discredit it. While Nim did learn 125 signs, Terrace concluded that he had not acquired anything the researchers were prepared to designate worthy of the name "language" (as defined by Noam Chomsky) although he had learned to repeat his trainers' signs in appropriate contexts. Language is defined as a "doubly articulated" system, in which signs are formed for objects and states and then combined syntactically, in ways that determine how their meanings will be understood. For example, "man bites dog" and "dog bites man" use the same set of words but because of their ordering will be understood by speakers of English as denoting very different meanings. For one thing, they say, there's no syntax — a basic requirement of language. Without combining words and then being able to switch combinations to change meaning, goes the argument, what animals use is more like a code than a language.[5] One of Terrace's colleagues, Laura-Ann Petitto, estimated that with more standard criteria, Nim's true vocabulary count was closer to 25 than 125. However, other students who cared for Nim longer than Petitto disagreed with her and with the way that Terrace conducted his experiment. Critics assert that Terrace used his analysis to destroy the movement of ape-language research. Terrace argued that none of the chimps were using language, because they could learn signs but could not form them syntactically as language, as described above. Terrace and his colleagues concluded that the chimpanzee did not show any meaningful sequential behavior that rivaled human grammar. Nim's use of language was strictly pragmatic, as a means of obtaining an outcome, unlike a human child's, which can serve to generate or express meanings, thoughts or ideas. There was nothing Nim could be taught that could not equally well be taught to a pigeon using the principles of operant conditioning. The researchers therefore questioned claims made on behalf of Washoe, and argued that the apparently impressive results may have amounted to nothing more than a "Clever Hans" effect, not to mention a relatively informal experimental approach
HERE;

        $words = explode(' ', $projectNim);

        $nbWords = rand(100,500);
        $sWords = array();
        for ($i = 0; $i < $nbWords; $i ++) {
            $sWords[] = $words[rand(0, (count($words) - 1))];
        }

        return implode(' ', $sWords);
    }
}

