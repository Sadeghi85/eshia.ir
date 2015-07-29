<?php namespace Sadeghi85\Docx2Html;

class Docx2Html
{
    /**
     * object zipArchive 
     * @var string
     * @access private
     */
    private $docx;

    /**
     * object domDocument from document.xml
     * @var string
     * @access private
     */
    private $domDocument;
	
	/**
     * object domDocument from footnotes.xml
     * @var string
     * @access private
     */
    private $domFootnote;
    
    /**
     * xml from document.xml
     * @var string
     * @access private
     */
    private $_document;
	
	/**
     *  xml from footnote
     * @var string
     * @access private
     */
    private $_footnote;
    
    /**
     * xml from numbering.xml
     * @var string
     * @access private
     */
    private $_numbering;
    
	private $_footnoteRelation;
	
	private $_documentRelation;
    
    /**
     * array of all the footnotes of the document
     * @var string
     * @access private
     */
    #private $footnotes;
	
	private $footnoteRelations;
	
	private $documentRelations;

    /**
     * array of characters to insert like a list
     * @var string
     * @access private
     */
    private $numberingList;

    /**
     * the html content that will be exported
     * @var string
     * @access private
     */
    private $htmlOutput;
    
    /**
     * boolean variable to know if a list will be transformed to text
     * @var string
     * @access private
     */
    private $list2html;
    
    /**
     * Construct
	 * @param string path to the docx
     * @param array of boolean values of which elements should be transformed or not
     * @access public
     */
    public function __construct($docPath, $options = array()) 
    {
        //list, paragraph, footnote
		$this->list2html = isset($options['list']) ? (bool) $options['list'] : true;

		$this->domDocument = new \DomDocument();
		$this->domFootnote = new \DomDocument();
		
        $this->htmlOutput = '';  
        $this->docx = null;
		
        $this->numberingList= array();
        $this->footnotes = array();
		
		$this->docx = new \ZipArchive();
		
        if (true === ($ZipArchiveErrorCode = $this->docx->open($docPath)))
		{
            $this->_document = $this->docx->getFromName('word/document.xml');
			$this->_documentRelation = $this->docx->getFromName('word/_rels/document.xml.rels');
			
			$this->_numbering = $this->docx->getFromName('word/numbering.xml');
			
            $this->_footnote = $this->docx->getFromName('word/footnotes.xml');
            $this->_footnoteRelation = $this->docx->getFromName('word/_rels/footnotes.xml.rels');
        }
		else
		{
			switch ($ZipArchiveErrorCode)
			{
				case \ZipArchive::ER_INCONS:
				case \ZipArchive::ER_NOZIP:
					throw new Docx2HtmlException('The document is malformed.');
					break;
				case \ZipArchive::ER_MEMORY:
				case \ZipArchive::ER_READ:
				case \ZipArchive::ER_SEEK:
				case \ZipArchive::ER_OPEN:
				case \ZipArchive::ER_NOENT:
				case \ZipArchive::ER_INVAL:
				default:
					throw new Docx2HtmlException('Can\'t open the document.');
			}
		}
		
		if ( ! $this->_document or ! $this->domDocument->loadXML($this->_document))
		{
            throw new Docx2HtmlException('Can\'t open the document.');
        }
		
		if ($this->_footnote and ! $this->domFootnote->loadXML($this->_footnote))
		{
            throw new Docx2HtmlException('Can\'t open the document.');
        }

		#$this->_loadFootnotes();
		$this->_loadFootnoteRelations();
		$this->_loadDocumentRelations();
		
		$this->_convert();
    }
	

    /** 
     * Extract the content of a word document and convert to html 
     * @access private
     */
    private function _convert()
    {
		$xpath = new \DOMXPath($this->domDocument);
		
		//get the body node to check the content from all its children. it is known that there is only one body tag
        $bodyNode = $this->domDocument->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'body');
		
        $query = 'w:p';
		$paragraphs = $xpath->query($query, $bodyNode->item(0));
		
        foreach($paragraphs as $paragraph)
		{
			$this->htmlOutput .= sprintf('<p>%s</p>', $this->_render($paragraph));
        }
    }
	
	/**
     * Extract the content of a w:p tag
     * 
     * @access private
     * @param $node is an object DOMNode
     */
    private function _render($node) 
    {
		$ret = '';
		
		$xpath = new \DOMXPath($this->domDocument);
		
        $query = './/w:r';
		$xmlRuns = $xpath->query($query, $node);
		
		foreach ($xmlRuns as $xmlRun)
		{
			$query = 'w:footnoteReference';
			$footnoteReference = $xpath->query($query, $xmlRun);
			if ($footnoteReference->length)
			{
				$ret .= $this->_renderFootnote($footnoteReference->item(0));
				continue;
			}
			
			$query = 'w:cr';
			$cr = $xpath->query($query, $xmlRun);
			if ($cr->length)
			{
				$ret .= '<br/>';
				continue;
			}
			
			$query = '..';
			$hyperlink = $xpath->query($query, $xmlRun);
			$hyperlinkTarget = '';
			if ($hyperlink->item(0)->localName == 'hyperlink')
			{
				$hyperlinkTarget = $this->documentRelations[$hyperlink->item(0)->getAttribute('r:id')];
			}
			
			$query = 'w:t';
			$text = $xpath->query($query, $xmlRun);
			if ($text->length)
			{
				$tmpText = $text->item(0)->textContent;
				
				$query = 'w:rPr/w:color';
				$color = $xpath->query($query, $xmlRun);
				$query = 'w:rPr/w:b';
				$bold = $xpath->query($query, $xmlRun);
				$query = 'w:rPr/w:i';
				$italic = $xpath->query($query, $xmlRun);
				$query = 'w:rPr/w:u';
				$underline = $xpath->query($query, $xmlRun);
				$query = 'w:rPr/w:strike';
				$strike = $xpath->query($query, $xmlRun);
				
				if ($color->length)
				{
					$tmpText = sprintf('<span class="%s">%s</span>', $color->item(0)->getAttribute('w:val'), $tmpText);
				}
				
				if ($bold->length)
				{
					$tmpText = sprintf('<b>%s</b>', $tmpText);
				}
				
				if ($italic->length)
				{
					$tmpText = sprintf('<i>%s</i>', $tmpText);
				}
				
				if ($underline->length)
				{
					$tmpText = sprintf('<u>%s</u>', $tmpText);
				}
				
				if ($strike->length)
				{
					$tmpText = sprintf('<strike>%s</strike>', $tmpText);
				}
				
				if ($hyperlinkTarget)
				{
					$tmpText = sprintf('<a href="%s" target="_blank">%s</a>', $hyperlinkTarget, $tmpText);
				}
				
				$ret .= $tmpText;
				
			}
			
		}
		
        // if ($this->list2html)
		// {
			// #transform the list in ooxml to formatted list with tabs and bullets
			
			// $ilvl = $numId = -1;
			
            // $this->listNumbering();
            
            // $query = 'w:pPr/w:numPr';
            // $xmlLists = $xpath->query($query, $node);
            // $xmlLists = $xmlLists->item(0);

            // if (isset($xmlLists) && $xmlLists->tagName == 'w:numPr')
			// {
                // if ($xmlLists->hasChildNodes())
				// {
                    // foreach ($xmlLists->childNodes as $child)
					// {
                        // if ($child->tagName == 'w:ilvl')
						// {
                            // $ilvl = $child->getAttribute('w:val'); 
                        // }
						// elseif ($child->tagName == 'w:numId')
						// {
                            // $numId = $child->getAttribute('w:val');
                        // }
                    // }
                // }
            // }
			
            // if (($ilvl != -1) && ($numId != -1))
			// {
                // #if is founded the style index of the list in the document and the kind of list
                // $ret = '';
                // for($i=-1; $i < $ilvl; $i++)
				// {
					// $ret .= "\t";
                // }
                // $ret .= array_shift($this->numberingList[$numId][$ilvl]) . ' ' . $this->toText($node);  //print the bullet
            // }
			// else
			// {
                // $ret = $this->toText($node);
            // }
        // }
		// else
		// {
            //if dont want to formatted lists, we strip from html tags
            //$ret = $this->toText($node);
        //}

        //extract the expecific footnote to insert with the text content
        
		// if ($this->footnote2text)
		// {
            // $this->loadFootNote();
            
            // $query = 'w:r/w:footnoteReference';
            // $xmlFootNote = $xpath->query($query, $node);
            // foreach ($xmlFootNote as $note)
			// {
			
                // #$ret .= '[' . $this->footnotes[$note->getAttribute('w:id')] . '] ';
				
				// $ret = str_replace('<ftr:'.$note->getAttribute('w:id').'/>', '[' . $this->footnotes[$note->getAttribute('w:id')] . '] ', $ret);
            // }
        // }
		
        //if((($ilvl != -1) && ($numId != -1)) || (1)) {
		  //$ret .= $this->separator();
        //}
		
		$ret = $ret ? trim($ret) : '&nbsp;';
		
        return $ret;
    }
    
	/**
     * Returns the html as string
     * @access public
     * @return string
     */
	public function getHtml()
	{
		return $this->htmlOutput;
	}

    /**
     * Save the html to file
     * @access public
     * @param path of the file
	 * @return bool
     */
    public function saveHtml($filePath) 
    {
		if (false === file_put_contents($filePath, $this->htmlOutput))
		{
			return false;
		}
        
		return true;
    }

	private function _renderFootnote($node) 
    {
		$xpath = new \DOMXPath($this->domFootnote);
		
        $footnotesNode = $this->domDocument->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'footnotes');
		
		$query = sprintf('%s[@%s=%s]', 'w:footnote', 'w:id', $node->getAttribute('w:id'));
		$footnoteNode = $xpath->query($query, $footnotesNode->item(0));
		
        $query = './/w:r';
		$xmlRuns = $xpath->query($query, $footnoteNode->item(0));
		
		$ret = '';
		
		foreach ($xmlRuns as $key => $xmlRun)
		{
			$query = 'w:cr';
			$cr = $xpath->query($query, $xmlRun);
			if ($cr->length)
			{
				$ret .= '<br/>';
				continue;
			}
			
			$query = '..';
			$hyperlink = $xpath->query($query, $xmlRun);
			$hyperlinkTarget = '';
			if ($hyperlink->item(0)->localName == 'hyperlink')
			{
				$hyperlinkTarget = $this->footnoteRelations[$hyperlink->item(0)->getAttribute('r:id')];
			}
			
			$query = 'w:t';
			$text = $xpath->query($query, $xmlRun);
			if ($text->length)
			{
				$tmpText = $text->item(0)->textContent;
				
				$query = 'w:rPr/w:color';
				$color = $xpath->query($query, $xmlRun);
				$query = 'w:rPr/w:b';
				$bold = $xpath->query($query, $xmlRun);
				$query = 'w:rPr/w:i';
				$italic = $xpath->query($query, $xmlRun);
				$query = 'w:rPr/w:u';
				$underline = $xpath->query($query, $xmlRun);
				$query = 'w:rPr/w:strike';
				$strike = $xpath->query($query, $xmlRun);
				
				if ($color->length)
				{
					$tmpText = sprintf('<span class="%s">%s</span>', $color->item(0)->getAttribute('w:val'), $tmpText);
				}
				
				if ($bold->length)
				{
					$tmpText = sprintf('<b>%s</b>', $tmpText);
				}
				
				if ($italic->length)
				{
					$tmpText = sprintf('<i>%s</i>', $tmpText);
				}
				
				if ($underline->length)
				{
					$tmpText = sprintf('<u>%s</u>', $tmpText);
				}
				
				if ($strike->length)
				{
					$tmpText = sprintf('<strike>%s</strike>', $tmpText);
				}
				
				if ($hyperlinkTarget)
				{
					$tmpText = sprintf('<a href="%s" target="_blank">%s</a>', $hyperlinkTarget, $tmpText);
				}
				
				$ret .= $tmpText;
				
			}
			
		}
		
		$ret = $ret ? trim($ret) : '&nbsp;';
		
        return sprintf('<ref>%s</ref>', $ret);
		
		// $text = $this->footnotes[$node->getAttribute('w:id')]['text'];
		
		// if (isset($this->footnotes[$node->getAttribute('w:id')]['hyperlinkId']))
		// {
			// return sprintf('<ref>[%s %s]</ref>', $this->footnoteRelations[$this->footnotes[$node->getAttribute('w:id')]['hyperlinkId']], $text);
		// }
		
		// return sprintf('<ref>%s</ref>', $text);
    }
	
    /**
     * Extract the content to an array from footnote.xml
     *
     * @access private
     */
    // private function _loadFootnotes()
    // {
        // if (empty($this->footnotes))
		// {
            // if ($this->_footnote)
			// {
                // $domDocument = new \DomDocument();
                // $domDocument->loadXML($this->_footnote);
				// $footnotes = $domDocument->getElementsByTagName('footnotes');
				
				// $xpath = new \DOMXPath($domDocument);
				
                // foreach ($footnotes->item(0)->childNodes as $footnote)
				// {
					// if ($footnote->getAttribute('w:id') < 1)
					// {
						// continue;
					// }
						
					// $query = 'w:p/w:r/w:t|w:p/w:hyperlink/w:r/w:t';
					// $texts = $xpath->query($query, $footnote);
					// $text = '';
					
					// foreach ($texts as $t)
					// {
						// $text .= $t->textContent;
					// }
					
					// $this->footnotes[$footnote->getAttribute('w:id')]['text'] = trim($text);
					
					// $query = 'w:p/w:hyperlink';
					// $hyperlink = $xpath->query($query, $footnote);

					// if ($hyperlink->length)
					// {
						// $this->footnotes[$footnote->getAttribute('w:id')]['hyperlinkId'] = $hyperlink->item(0)->getAttribute('r:id');
					// }
                // }
            // }
        // }
    // }
	
	private function _loadFootnoteRelations()
    {
        if (empty($this->footnoteRelations))
		{
            if ($this->_footnoteRelation)
			{
                $domDocument = new \DomDocument();
                $domDocument->loadXML($this->_footnoteRelation);
                $footnoteRelations = $domDocument->getElementsByTagName('Relationships');
				$footnoteRelations = $footnoteRelations->item(0);
				
                foreach ($footnoteRelations->childNodes as $footnoteRelation)
				{
                    $this->footnoteRelations[$footnoteRelation->getAttribute('Id')] = $footnoteRelation->getAttribute('Target');
                }
            }
        }
    }
	
	private function _loadDocumentRelations()
    {
        if (empty($this->documentRelations))
		{
            if ($this->_documentRelation)
			{
                $domDocument = new \DomDocument();
                $domDocument->loadXML($this->_documentRelation);
                $documentRelations = $domDocument->getElementsByTagName('Relationships');
				
                foreach ($documentRelations->item(0)->childNodes as $documentRelation)
				{
                    $this->documentRelations[$documentRelation->getAttribute('Id')] = $documentRelation->getAttribute('Target');
                }
            }
        }
    }

    /**
     * Extract the styles of the list to an array
     *
     * @access private
     */
    private function listNumbering() 
    {
        $ids = array();
        $nums = array();
        
        if(!empty($this->_numbering)){
            //we use the domdocument to iterate the children of the numbering tag 
            $domDocument = new \DomDocument();
            $domDocument->loadXML($this->_numbering);
            $numberings = $domDocument->getElementsByTagNameNS('http://schemas.openxmlformats.org/wordprocessingml/2006/main', 'numbering');
            //there is only one numbering tag in the numbering.xml
            $numberings = $numberings->item(0);
            foreach ($numberings->childNodes as $child) {
                $flag = true;//boolean variable to know if the node is the first style of the list
                foreach ($child->childNodes as $son) {
                    if ($child->tagName == 'w:abstractNum' && $son->tagName == 'w:lvl') {
                        foreach ($son->childNodes as $daughter) {
                            if ($daughter->tagName == 'w:numFmt' && $flag) {
                                $nums[$child->getAttribute('w:abstractNumId')] = $daughter->getAttribute('w:val');//set the key with internal index for the listand the value it is the type of bullet
                                $flag = false;
                            }
                        }
                    } elseif ($child->tagName == 'w:num' && $son->tagName == 'w:abstractNumId') {
                        $ids[$son->getAttribute('w:val')] = $child->getAttribute('w:numId');//$ids is the index of the list
                    }
                }
            }
            //once we know what kind of list there is in the documents, is prepared the bullet that the library will use
            foreach ($ids as $ind => $id) {
                if ($nums[$ind] == 'decimal') {
                    //if the type is decimal it means that the bullet will be numbers
                    $this->numberingList[$id][0] = range(1, 10);
                    $this->numberingList[$id][1] = range(1, 10);
                    $this->numberingList[$id][2] = range(1, 10);
                    $this->numberingList[$id][3] = range(1, 10);
                } else {
                    //otherwise is *, and other characters
                    $this->numberingList[$id][0] = array('*', '*', '*', '*', '*', '*', '*', '*', '*', '*', '*', '*', '*', '*', '*', '*', '*');
                    $this->numberingList[$id][1] = array(chr(175),chr(175),chr(175),chr(175),chr(175),chr(175),chr(175),chr(175),chr(175),chr(175),chr(175),chr(175));
                    $this->numberingList[$id][2] = array(chr(237),chr(237),chr(237),chr(237),chr(237),chr(237),chr(237),chr(237),chr(237),chr(237),chr(237),chr(237));
                    $this->numberingList[$id][3] = array(chr(248),chr(248),chr(248),chr(248),chr(248),chr(248),chr(248),chr(248),chr(248),chr(248),chr(248));
                }
            }
        }
    }

    /**
     * Extract the content of word/_rels/document._rels.xml
     *
     * @access private
     */
    private function loadRelations() 
    {
        if (empty($this->relations)) {
            
            $domDocument = new \DomDocument();
            $domDocument->loadXML($this->_relations);
            $relations = $domDocument->getElementsByTagName('Relationships');
            $relations = $relations->item(0);
            foreach ($relations->childNodes as $relation) {
                $this->relations[$relation->getAttribute('Id')]['file'] = $relation->getAttribute('Target');
                $this->relations[$relation->getAttribute('Id')]['type'] = $relation->getAttribute('Type');
            }
        }
    }

    /**
     * return a text end of line
     *
     * @access private
     */
    private function separator() 
    {
	   return "\r\n";
    }

    /** 
     * 
     * Extract the content of a node from the document.xml and return only the text content and. stripping the html tags
     * 
     * @access private
     * @param $node is a object DOMNode
     * 
     */
    private function toText($node) 
    {
        // $xml = $node->ownerDocument->saveXML($node);
        // return trim(strip_tags ($xml));
		
		$ret = '';
		
		//use the xpath to get expecific children from a node
		//$xpath = new \DOMXPath($this->domDocument);
		
		//var_dump($ret);
		return $ret;
    }
}
