<?php
class RedditSubExtension extends Minz_Extension 
{
	public function init()
	{
    	Minz_View::appendStyle($this->getFileUrl('style.css', 'css'));
		$this->registerHook('entry_before_display', array($this, 'renderEntry'));
	}
	
	
	protected function isRedditLink($entry)
	{
        return (bool) strpos($entry->link(), 'reddit.com');
    }
	
	
    protected function extractSubreddit($content)
    {
        $match_url = '#<a href="https://www.reddit.com/r/.*"> (.*) </a>#';

        if ( preg_match($match_url, $content, $matches) )  
        {
            return $matches[1];        
        }    
    }
    
    
	public function renderEntry($entry) 
	{
        if (false === $this->isRedditLink($entry)) 
        {
                return $entry;
        }
        
        $sub = $this->extractSubreddit( $entry->content() );
        
		$entry->_title( "<span class='subreddit_name'>$sub</span> " . $entry->title() );
		return $entry;
	}
}
