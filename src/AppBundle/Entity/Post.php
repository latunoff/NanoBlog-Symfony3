<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 * @ORM\Table(name="posts")
 */
class Post
{
    const NUM_ITEMS = 10;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */

/**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $title_en;
/**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $title_de;

    /**
     * @ORM\Column(type="string")
     */
    private $slug;

/**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="post.blank_content")
     * @Assert\Length(min = "10", minMessage = "post.too_short_content")
     */
    private $content_en;
/**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="post.blank_content")
     * @Assert\Length(min = "10", minMessage = "post.too_short_content")
     */
    private $content_de;

    /**
     * @return mixed
     */

    public function __construct()
    {
        $this->publishedAt = new \DateTime();
        //$this->loc = $request->getLocale();
    }

    public function getContent($loc)
    {
        $var = 'content_'.$loc;
        return $this->$var;
    }

    public function getContentEn()
    {
        return $this->content_en;
    }

    /**
     * @param mixed $content_en
     */
    public function setContentEn($content_en)
    {
        $this->content_en = $content_en;
    }

    /**
     * @return mixed
     */
    public function getContentDe()
    {
        return $this->content_de;
    }

    /**
     * @param mixed $content_de
     */
    public function setContentDe($content_de)
    {
        $this->content_de = $content_de;
    }

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $authorName;

    /**
     * @return mixed
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param mixed $authorName
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @ORM\Column(type="string")
     * @Assert\Email()
     */
    private $authorEmail;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $publishedAt;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitleEn()
    {
        return $this->title_en;
    }

    public function getTitle($loc)
    {
        $var = 'title_'.$loc;
        return $this->$var;
    }

    /**
     * @param mixed $title_en
     */
    public function setTitleEn($title_en)
    {
        $this->title_en = $title_en;
    }

    /**
     * @return mixed
     */
    public function getTitleDe()
    {
        return $this->title_de;
    }

    /**
     * @param mixed $title_de
     */
    public function setTitleDe($title_de)
    {
        $this->title_de = $title_de;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isAuthor(User $user)
    {
        return $user->getEmail() === $this->getAuthorEmail();
    }

    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTime $publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function addComment(Comment $comment)
    {
        $this->comments->add($comment);
        $comment->setPost($this);
    }

    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }
}
