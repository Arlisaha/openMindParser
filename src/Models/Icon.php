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
	 * @var String $filePath : The file path of the icon understandable by HTPP protocol. If it is a builtin icon, then it is in the 'img' directory of the project.
	 */
	private $filePath;
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
	 * @param String $filePath : The file path of the icon. If it is a builtin icon, then it is in the 'img' directory of the project.
	 * @param int $size : The size of the file.
	 * @param String $extension : The extension of the icon file without the leading dot. If it is a builtin icon, then it is 'png'.
	 */ 
	public function __construct($name = null, $extension = null, $filePath = null, $size = null) {
		if(!empty($name)) {
			$this->setIcon($name, $extension, $filePath, $size);
		}
	}
	
	/**
	 * Fill all the instance attributes according to the given parameters.
	 * If only the name is given , then it will assume that a builtin icon is beeing used so the aother attributes will be filled following this logic.
	 * 
	 * @param String $name : The name of the icon without the path or the extension.
	 * @param String $filePath : The file path of the icon. If it is a builtin icon, then it is in the 'img' directory of the project.
	 * @param int $size : The size of the file.
	 * @param String $extension : The extension of the icon file without the leading dot. If it is a builtin icon, then it is 'png'.
	 */ 
	public function setIcon($name, $extension = null, $filePath = null, $size = null) {
		$this->name = $name;
		$this->extension = $extension ?: 'png';
		$this->filePath = $filePath ?: realpath(__DIR__.'/../../img/'.$this->name.'.'.$this->extension);
		
		if(!file_exists($this->filePath)) {
			throw new UnexistentFileException('The file '.$this->filePath.' does not exist !');
		}
		
		$this->size = filesize($this->filePath);
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
	 public function getFilePath() {
	 	return $this->filePath;
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
	 * Magic to String method.
	 * 
	 * @return String
	 */
	public function __toString() {
		return $this->getFilePath();
	}
}