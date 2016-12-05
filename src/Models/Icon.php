<?php

namespace OpenMindParser\Models;

use OpenMindParser\Exceptions\UnexistentFileException;

/*Object that represent an Icon.*/
class Icon 
{
	/**
	 * @var String $name : The name of the icon without the path or the extension.
	 */
	private $name;
	/**
	 * @var String $fullName : The name of the icon without the path but with the extension.
	 */
	private $fullName;
	/**
	 * @var String $filePath : The file path of the icon. If it is a builtin icon, then it is in the 'img' directory of the project.
	 */
	private $path;
	/**
	 * @var String $shortUri : The short uri to thye image. Will be used for exports. If it is a builtin icon, value will be '/img/'.
	 */
	private $shortUri;
	/**
	 * @var int $size : The size of the file.
	 */
	private $size;
	/**
	 * @var String $extension : The extension of the icon file without the leading dot. If it is a builtin icon, then it is 'png'.
	 */
	private $extension;
	
	/**
	 * The constructor. Use setIcon method.
	 * 
	 * @param String $name : The name of the icon without the path or the extension.
	 * @param String $path : The file path of the icon. If it is a builtin icon, then it is in the 'img' directory of the project.
	 * @param String $shortUri : The short uri to thye image. Will be used for exports. If it is a builtin icon, value will be '/img/'.
	 * @param int $size : The size of the file.
	 * @param String $extension : The extension of the icon file without the leading dot. If it is a builtin icon, then it is 'png'.
	 */ 
	public function __construct($name = null, $extension = null, $path = null, $shortUri = null, $size = null) {
		if(!empty($name)) {
			$this->setIcon($name, $extension, $path, $shortUri, $size);
		}
	}
	
	/**
	 * Fill all the instance attributes according to the given parameters.
	 * If only the name is given , then it will assume that a builtin icon is beeing used so the aother attributes will be filled following this logic.
	 * 
	 * @param String $name : The name of the icon without the path or the extension.
	 * @param String $path : The file path of the icon. If it is a builtin icon, then it is in the 'img' directory of the project.
	 * @param String $shortUri : The short uri to thye image. Will be used for exports. If it is a builtin icon, value will be '/img/'.
	 * @param int $size : The size of the file.
	 * @param String $extension : The extension of the icon file without the leading dot. If it is a builtin icon, then it is 'png'.
	 */ 
	public function setIcon($name, $extension = null, $path = null, $shortUri = null, $size = null) {
		$this->name = $name;
		$this->extension = $extension ?: 'png';
		$this->fullName = $this->name.'.'.$this->extension;
		$this->shortUri = $shortUri ?: '/img/'.$this->fullName;
		$this->path = $path ?: realpath(__DIR__.'/../../img/'.$this->fullName);
		
		if(!file_exists($this->path)) {
			throw new UnexistentFileException('The file '.$this->path.' does not exist !');
		}
		
		$this->size = filesize($this->path);
	}
	
	/**
	 * Return icon name.
	 * 
	 * @return String : the icon name.
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Return the full icon name.
	 * 
	 * @return String : the full icon name.
	 */
	public function getFullName() {
		return $this->fullName;
	}
	
	/**
	 * Return icon extension.
	 * 
	 * @return String : the icon extension.
	 */
	public function getExtension() {
		return $this->extension;
	}
	
	/**
	 * Return icon file path.
	 * 
	 * @return String : the icon path.
	 */
	 public function getPath() {
	 	return $this->path;
	 }
	
	/**
	 * Return icon short uri.
	 * 
	 * @return String : the icon short uri.
	 */
	 public function getShortUri() {
	 	return $this->shortUri;
	 }
	
	/**
	 * Set the icon short uri.
	 * 
	 * @return String : the icon uri.
	 */
	 public function setShortUri($shortUri) {
	 	$this->shortUri = $shortUri;
	 }
	
	/**
	 * Return icon name.
	 * 
	 * @return int : the icon size.
	 */
	public function getSize() {
		return $this->size;
	}
	
	/**
	 * Transform the objects tree in an array tree.
	 * 
	 * @return Array $array : The array tree.
	 */
	public function toArray() {
		return get_object_vars($this);
	}
	
	/**
	 * Magic to String method.
	 * 
	 * @return String
	 */
	public function __toString() {
		return $this->getPath();
	}
}