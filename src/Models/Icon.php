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
	 * @var String $fullFilePath : The full file path of the icon (absolute filePath for system root with extension). If it is a builtin icon, then it is in the 'img' directory of the project.
	 */
	private $fullFilePath;
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
	 * @param String $fullFilePath : The full file path of the icon (relative filePath with extension). If it is a builtin icon, then it is in the 'img' directory of the project.
	 * @param String $filePath : The file path of the icon understandable by HTPP protocol. If it is a builtin icon, then it is in the 'img' directory of the project.
	 * @param int $size : The size of the file.
	 * @param String $extension : The extension of the icon file without the leading dot. If it is a builtin icon, then it is 'png'.
	 */ 
	public function __construct($name = null, $extension = null, $fullFilePath = null, $filePath = null, $size = null) {
		if(!empty($name)) {
			$this->setIcon($name, $extension, $fullFilePath, $filePath, $size);
		}
	}
	
	/**
	 * Fill all the instance attributes according to the given parameters.
	 * If only the name is given , then it will assume that a builtin icon is beeing used so the aother attributes will be filled following this logic.
	 * 
	 * @param String $name : The name of the icon without the path or the extension.
	 * @param String $fullFilePath : The full file path of the icon (relative filePath with extension). If it is a builtin icon, then it is in the 'img' directory of the project.
	 * @param String $filePath : The file path of the icon understandable by HTPP protocol. If it is a builtin icon, then it is in the 'img' directory of the project.
	 * @param int $size : The size of the file.
	 * @param String $extension : The extension of the icon file without the leading dot. If it is a builtin icon, then it is 'png'.
	 */ 
	public function setIcon($name, $extension = null, $fullFilePath = null, $filePath = null, $size = null) {
		$this->name = $name;
		$this->extension = $extension ?: 'png';
		$this->fullFilePath = $fullFilePath ?: realpath(IMG_FULL_ROOT_DIR.$this->name.'.'.$this->extension);
		$this->filePath = $filePath ?: IMG_ROOT_DIR.$this->name.'.'.$this->extension;;
		
		if(!file_exists($this->fullFilePath)) {
			throw new UnexistentFileException('The file '.$this->fullFilePath.' does not exist !');
		}
		
		$this->size = filesize($this->fullFilePath);
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
	 * Return icon full path.
	 * 
	 * @return String : the icon full path.
	 */
	public function getFullFilePath() {
		return $this->fullFilePath;
	}
	
	/**
	 * Return icon file path for HTML resolution.
	 * 
	 * @return String : the icon HTML path.
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