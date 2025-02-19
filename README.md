# news-content-columns
Render the additional content elements of news in your desired column

## Installation
`composer require traw/news-content-columns`

## Configuration

No additional config.

## Usage

If installed, the extension automatically filters the content element that are attached to a news record. 
All records are removed, that don't have the same colPos as the News-Detail-Plugin.


On the page where the News-Detail-Plugin is located, place the `News Content Columns` plugin in another column to render the content elements of the news record that have this colPos.

## Example

Assume you have a 3-column layout.

In the news record's content elements, decide where to put the content element

![colPos of content elements](Documentation/colPos.png)

![Content in News Record](Documentation/content.png)

Place the plugin in the columns:

![Plugins in columns](Documentation/columns.png)

The content elements will be rendered in the corresponding column

![Result](Documentation/result.png)




## Credits:

Extension icon shamelessly copied from https://typo3.github.io/TYPO3.Icons/icons/overlay/overlay-news.html
