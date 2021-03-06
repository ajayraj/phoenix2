<?php

namespace AppBundle\Entity;

use AppBundle\Respositor\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="users")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $username;
    
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;
    
    /**
     * @ORM\Column(name="sid", type="string", length=64)
     */
    private $SID;
    
    /**
     * @ORM\Column(name="card_number", type="string", length=64)
     */
    private $cardNumber;
    
    /**
     * @ORM\Column(name="checked_in", type="boolean")
     */
    private $checkedIn = false;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $attendance = 0;
    
    /**
     * @ORM\Column(name="shirt_size", type="string", length=32)
     */
    private $shirtSize;
    
    /**
     * @ORM\Column(name="paid", type="boolean")
     */
    private $paid = false;
    
    /**
     * @ORM\Column(type="string")
     */
    private $role;
    
    /**
     * @ORM\Column(name="profile_photo", type="string")
     * @Assert\File(mimeTypes={ "image/gif", "image/jpeg", "image/png", "image/bmp", "image/tiff" })
     */
    private $profilePhoto = 'img/users/default.jpg';

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="author")
     */
    private $posts;
    
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="author")
     */
    private $comments;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     * @ORM\OneToOne(targetEntity="Student")
     * @ORM\JoinColumn(name="student_card_number", referencedColumnName="card_number")
     */
    private $student;
    
    // Getters/Setters

    public function __construct()
    {
        $this->isActive = true;
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getSalt()
    {
        return null;
    }
    
    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRoles($role)
    {
        $this->role = $role;
        return $this;
    }

    public function getRoles()
    {
        return array($this->role);
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
        ) = unserialize($serialized);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set sID
     *
     * @param string $sID
     *
     * @return User
     */
    public function setSID($sID)
    {
        $this->SID = $sID;

        return $this;
    }

    /**
     * Get sID
     *
     * @return string
     */
    public function getSID()
    {
        return $this->SID;
    }

    /**
     * Set cardNumber
     *
     * @param string $cardNumber
     *
     * @return User
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * Get cardNumber
     *
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * Set checkedIn
     *
     * @param boolean $checkedIn
     *
     * @return User
     */
    public function setCheckedIn($checkedIn)
    {
        $this->checkedIn = $checkedIn;

        return $this;
    }

    /**
     * Get checkedIn
     *
     * @return boolean
     */
    public function getCheckedIn()
    {
        return $this->checkedIn;
    }

    /**
     * Set attendance
     *
     * @param integer $attendance
     *
     * @return User
     */
    public function setAttendance($attendance)
    {
        $this->attendance = $attendance;

        return $this;
    }

    /**
     * Get attendance
     *
     * @return integer
     */
    public function getAttendance()
    {
        return $this->attendance;
    }

    /**
     * Set shirtSize
     *
     * @param string $shirtSize
     *
     * @return User
     */
    public function setShirtSize($shirtSize)
    {
        $this->shirtSize = $shirtSize;

        return $this;
    }

    /**
     * Get shirtSize
     *
     * @return string
     */
    public function getShirtSize()
    {
        return $this->shirtSize;
    }

    /**
     * Set paid
     *
     * @param boolean $paid
     *
     * @return User
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return boolean
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Add post
     *
     * @param \AppBundle\Entity\Post $post
     *
     * @return User
     */
    public function addPost(\AppBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \AppBundle\Entity\Post $post
     */
    public function removePost(\AppBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set profilePhoto
     *
     * @param string $profilePhoto
     *
     * @return User
     */
    public function setProfilePhoto($profilePhoto)
    {
        $this->profilePhoto = $profilePhoto;

        return $this;
    }

    /**
     * Get profilePhoto
     *
     * @return string
     */
    public function getProfilePhoto()
    {
        return $this->profilePhoto;
    }

    /**
     * Add comment
     *
     * @param \AppBundle\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \AppBundle\Entity\Comment $comment
     */
    public function removeComment(\AppBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add event
     *
     * @param \AppBundle\Entity\Attendance $event
     *
     * @return User
     */
    public function addEvent(\AppBundle\Entity\Attendance $event)
    {
        $this->events[] = $event;
        $this->attendance++;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \AppBundle\Entity\Attendance $event
     */
    public function removeEvent(\AppBundle\Entity\Attendance $event)
    {
        $this->events->removeElement($event);
        $this->attendance--;
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set student
     *
     * @param \AppBundle\Entity\Student $student
     *
     * @return User
     */
    public function setStudent(\AppBundle\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \AppBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }
}
