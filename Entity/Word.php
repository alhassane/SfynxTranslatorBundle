<?php
/**
 * This file is part of the <Translator> project.
 *
 * @category   Translator
 * @package    Entity
 * @subpackage Model
 * @author     Riad HELLAL <hellal.riad@gmail.com>
 * @copyright  2015 PI-GROUPE
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    2.3
 * @link       http://opensource.org/licenses/gpl-license.php
 * @since      2015-02-16
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Sfynx\TranslatorBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Sfynx\CoreBundle\Model\AbstractDefault;

// importing @Encrypted annotation
use Sfynx\EncryptBundle\Annotation\Encryptors as PI;

/**
 * Sfynx\TranslatorBundle\Entity\Word
 *
 * @ORM\Table(name="pi_word")
 * @ORM\Entity(repositoryClass="Sfynx\TranslatorBundle\Repository\WordRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\TranslationEntity(class="Sfynx\TranslatorBundle\Entity\Translation\WordTranslation")
 * 
 * @category   Translator
 * @package    Entity
 * @subpackage Model
 * @author     Riad HELLAL <hellal.riad@gmail.com>
 * @copyright  2015 PI-GROUPE
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    2.3
 * @link       http://opensource.org/licenses/gpl-license.php
 * @since      2015-02-16
 */
class Word extends AbstractDefault
{
    /**
     * List of al translatable fields
     *
     * @var array
     * @access  protected
     */
    protected $_fields    = array('label');
    
    /**
     * Name of the Translation Entity
     *
     * @var array
     * @access  protected
     */
    protected $_translationClass = 'Sfynx\TranslatorBundle\Entity\Translation\WordTranslation';
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Sfynx\TranslatorBundle\Entity\Translation\WordTranslation", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;
        
    /**
     * @var string $id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $label
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="label", type="string", length=255, nullable=true)
     * @PI\Aesencrypted
     */
    protected $label;

    /**
     * @var string
     *
     * @ORM\Column(name="keyword", type="string", length=128, nullable=false, unique=true)
     * @PI\Aesencrypted
     * @Assert\NotBlank()
     */
    protected $keyword;
    
    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=128, nullable=true)
     */
    protected $category;
    
    /**
     * @var string
     *
     * @ORM\Column(name="categoryother", type="string", length=128, nullable=true)
     */
    protected $categoryother;


    public function __construct()
    {
        parent::__construct();        
        $this->setEnabled(true);
    }    
    
    /**
     *
     * This method is used when you want to convert to string an object of
     * this Entity
     * ex: $value = (string)$entity;
     *
     */
    public function __toString() {
        return (string) $this->label;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $other  = $this->getCategoryother();
        if (!empty($other)){
            $this->setCategory($other);
            $this->setCategoryother('');
        }
    }
    
    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get id
     *
     * @return string
     */
    public function setId($id)
    {
        $this->id = $id;
    }    

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set label
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Get keyword
     *
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }
    
    /**
     * Set keyword
     *
     * @param string $keyword
     */
    public function setkeyword($keyword)
    {
        $this->keyword = $keyword;
    }
    
    /**
     * Set category
     *
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
    
    /**
     * Get category
     *
     * @return string
     */
    
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * Set category
     *
     * @param string $category
     */
    public function setCategoryother($category)
    {
        $this->categoryother = $category;
    }
    
    /**
     * Get category
     *
     * @return string
     */
    public function getCategoryother()
    {
        return $this->categoryother;
    }    
}