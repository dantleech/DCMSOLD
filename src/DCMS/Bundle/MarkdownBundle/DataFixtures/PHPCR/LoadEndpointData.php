<?php

namespace DCMS\Bundle\MarkdownBundle\DataFixtures\PHPCR;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use DCMS\Bundle\MarkdownBundle\Document\MarkdownEndpoint;

class LoadEndpointData implements FixtureInterface, DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            'DCMS\Bundle\CoreBundle\DataFixtures\PHPCR\LoadSiteData',
        );
    }

    public function load(ObjectManager $manager)
    {
        $rt = $manager->find(null, '/sites/dantleech/endpoints');

        $e = new MarkdownEndpoint;
        $e->setParent($rt);
        $e->setTitle('Home');
        $e->setContent(<<<FOO
This is a test
==============

This is the most basic endpoint I can be bothered to make.
FOO
    );
        $manager->persist($e);

        $e = new MarkdownEndpoint;
        $e->setParent($rt);
        $e->setTitle('CV');
        $e->setContent(<<<FOO
Curriculum Vitae
================

This is my extensive CV.

What I do
---------

Not much

What I want to do
-----------------

Not much
FOO
    );
        $manager->persist($e);

        $about = new MarkdownEndpoint;
        $about->setParent($rt);
        $about->setTitle('About');
        $about->setContent(<<<FOO
About this site
FOO
    );
        $manager->persist($about);

        $e = new MarkdownEndpoint;
        $e->setParent($about);
        $e->setTitle('Me');
        $e->setContent(<<<FOO
About me
FOO
    );
        $manager->persist($e);

        $e = new MarkdownEndpoint;
        $e->setParent($about);
        $e->setTitle('Them');
        $e->setContent(<<<FOO
About them 
FOO
    );
        $manager->persist($e);
        $e = new MarkdownEndpoint;
        $e->setParent($rt);
        $e->setTitle('Finding stray commits');
        $e->setContent(<<<FOO
How many times have you done some work on some branch, which was not the right branch, only to go back to the branch you __thought__ you were working on, only to find out that your precious commit has dissapeared, where is it?

If your like me you have about 100 different branches, and needles, haystacks, etc.

Finding stray commits
---------------------

### git log -g

Git `log -g` will effectively list commits from all branches.

<pre>
git log -g
commit 0c07a178d6473aac90d72b6cb2256ef39fd69bff
Reflog: HEAD@{5} (Daniel Leech <daniel@ylyad.fr>)
Reflog message: checkout: moving from master to issue-2970
Author: dantleech <daniel@ylyad.fr>
Date:   Mon Oct 8 18:26:19 2012 +0200

    Merge remote-tracking branch 'benoit/issue-2962'

commit 0c07a178d6473aac90d72b6cb2256ef39fd69bff
Reflog: HEAD@{6} (Daniel Leech <daniel@ylyad.fr>)
Reflog message: checkout: moving from issue-2969 to master
Author: dantleech <daniel@ylyad.fr>
Date:   Mon Oct 8 18:26:19 2012 +0200

    Merge remote-tracking branch 'benoit/issue-2962'

commit fbda714a0ff32d034458dcc8a9958e3e48d56b19
Reflog: HEAD@{7} (Daniel Leech <daniel@ylyad.fr>)
Reflog message: commit: Issue #2969: Fixed contact form repository
Author: Daniel Leech <daniel@ylyad.fr>
Date:   Tue Oct 9 10:10:26 2012 +0200

    Issue #2969: Fixed contact form repository
</pre>

Ah -- theres my commit! (fbda714a0ff32d...)

Great -- but how to tell which branch it came from?

### git branch --contains

Pretty self-explanatory this one I think.

<pre>
git branch --contains fbda714a0ff32d034458dcc8a9958e3e48d56b19
issue-2969
</pre>

Hurah! My commit is in the branch **issue-2969**. (Which, conincidentally was the branch it should have been in!)
FOO
);
        $manager->persist($e);

        $manager->flush();
    }
}
