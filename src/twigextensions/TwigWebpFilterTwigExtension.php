<?php
/**
 * Twig Webp Filter plugin for Craft CMS 3.x
 *
 * Returns an Object containing webp and img data
 *
 * @link      https://github.com/danieladarve
 * @copyright Copyright (c) 2020 Daniel G Adarve
 */

namespace danieladarve\twigwebpfilter\twigextensions;

use danieladarve\twigwebpfilter\TwigWebpFilter;

use Craft;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use aelvan\imager\Imager;
use aelvan\imager\services\ImagerService;
use craft\web\twig\Environment;

/**
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators,
 * global variables, and functions. You can even extend the parser itself with
 * node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    Daniel G Adarve
 * @package   TwigWebpFilter
 * @since     0.0.1
 */
class TwigWebpFilterTwigExtension extends AbstractExtension
{
  // Public Methods
  // =========================================================================

  /**
   * Returns the name of the extension.
   *
   * @return string The extension name
   */
  public function getName()
  {
    return 'TwigWebpFilter';
  }

  /**
   * Returns an array of Twig filters, used in Twig templates via:
   *
   *      {{ 'something' | someFilter }}
   *
   * @return array
   */
  public function getFilters()
  {
    return [
      // new TwigFilter('someFilter', [$this, 'someInternalFunction']),
    ];
  }

  /**
   * Returns an array of Twig functions, used in Twig templates via:
   *
   *      {% set this = someFunction('something') %}
   *
   * @return array
   */
  public function getFunctions()
  {
    return [
      new TwigFunction('webp', [$this, 'webp']),
    ];
  }

  /**
   * Our function called via Twig; it can do anything you want
   *
   * @param $image
   * @param int $quality
   * @return string
   */
  public function webp($image, $quality = 75)
  {
    if (gettype($image) !== "object" || get_class($image) !== 'craft\elements\Asset') {
      return;
    }
    $imagerInstance = Imager::getInstance();
    $imager = $imagerInstance->imager;
    $placeholder = $imagerInstance->placeholder;

    $webp = ImagerService::hasSupportForWebP();
    $width = $image->getWidth();
    $height = $image->getHeight();
    $transform = [
      'width'       => $width,
      'height'      => $height,
      'jpegQuality' => $quality,
      'webpQuality' => $quality
    ];

    $pictureTransform = $imager->transformImage($image, $transform);

    if ($webp) {
      $pictureTransformWebp = $imager->transformImage($image, $transform, ['format' => 'webp']);
    }

    if ($pictureTransform || $webp) {
      $webpSrcset = FALSE;
      if ($webp) {
        $webpSrcset = $pictureTransformWebp->url;
      }
      $imgSrc = $pictureTransform->url;
      $alt = $image->title;

    }

    return [
      'webpSrcset' => $webpSrcset,
      'imgSrc'     => $imgSrc,
      'dataSrc'    => $imgSrc,
      'dataSrcSet' => $imgSrc,
      'alt'        => $alt,
    ];
  }
}
