<?php

class pluginRSS extends Plugin {

	public function init()
	{
		// Fields and default values for the database of this plugin
		$this->dbFields = array(
			'numberOfItems'=>5
		);
	}

	// Method called on the settings of the plugin on the admin area
	public function form()
	{
		global $L;

		$html  = '<div class="alert alert-primary" role="alert">';
		$html .= $this->description();
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('RSS URL').'</label>';
		$html .= '<a href="'.Theme::rssUrl().'">'.Theme::rssUrl().'</a>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Amount of items').'</label>';
		$html .= '<input id="jsnumberOfItems" name="numberOfItems" type="text" value="'.$this->getValue('numberOfItems').'">';
		$html .= '<span class="tip">'.$L->get('Amount of items to show on the feed').'</span>';
		$html .= '</div>';

		return $html;
	}

	private function createXML()
	{
		global $site;
		global $pages;
		global $url;

		// Amount of pages to show
		$numberOfItems = $this->getValue('numberOfItems');

		// Page number the first one
		$pageNumber = 1;

		// Only published pages
		$onlyPublished = true;

		// Get the list of pages
		$list = $pages->getList($pageNumber, $numberOfItems, $onlyPublished);

		$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
		$xml .= '<rss version="2.0">';
		$xml .= '<channel>';
		$xml .= '<title>'.$site->title().'</title>';
		$xml .= '<link>'.$site->url().'</link>';
		$xml .= '<description>'.$site->description().'</description>';
		$xml .= '<lastBuildDate>'.date(DATE_RSS).'</lastBuildDate>';

		// Get keys of pages
		foreach ($list as $pageKey) {
			try {
				// Create the page object from the page key
				$page = new Page($pageKey);
				$xml .= '<item>';
				$xml .= '<title>'.$page->title().'</title>';
				$xml .= '<link>'.$page->permalink().'</link>';
				$xml .= '<description>'.Sanitize::html($page->contentBreak()).'</description>';
				$xml .= '<pubDate>'.$page->date(DATE_RSS).'</pubDate>';
				$xml .= '<guid isPermaLink="false">'.$page->uuid().'</guid>';
				$xml .= '</item>';
			} catch (Exception $e) {
				// Continue
			}
		}

		$xml .= '</channel></rss>';

		// New DOM document
		$doc = new DOMDocument();
		$doc->formatOutput = true;
		$doc->loadXML($xml);
		return $doc->save($this->workspace().'rss.xml');
	}

	public function install($position=0)
	{
		parent::install($position);
		return $this->createXML();
	}

	public function post()
	{
		parent::post();
		return $this->createXML();
	}

	public function afterPageCreate()
	{
		$this->createXML();
	}

	public function afterPageModify()
	{
		$this->createXML();
	}

	public function afterPageDelete()
	{
		$this->createXML();
	}

	public function siteHead()
	{
		return '<link rel="alternate" type="application/rss+xml" href="'.DOMAIN_BASE.'rss.xml" title="RSS Feed">'.PHP_EOL;
	}

	public function beforeAll()
	{
		$webhook = 'rss.xml';
		if ($this->webhook($webhook)) {
			// Send XML header
			header('Content-type: text/xml');
			$doc = new DOMDocument();

			// Load XML
			libxml_disable_entity_loader(false);
			$doc->load($this->workspace().'rss.xml');
			libxml_disable_entity_loader(true);

			// Print the XML
			echo $doc->saveXML();

			// Stop Bludit execution
			exit(0);
		}
	}
}
