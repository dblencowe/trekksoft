<?php
/**
 * This file is part of TrekkSoft.
 *
 * (c) Philippe Gerber <philippe.gerber@trekksoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TrekkSoft\Widget;

class Generator
{
    const ENDPOINT_PATH = '/api/public';
    
    const LOGO_WIDTH    = 140;
    const LOGO_HEIGHT   = 30;

    const TARGET_FANCY  = 'fancy';
    const TARGET_POPUP  = 'popup';
    const TARGET_WINDOW = 'window';
    const TARGET_URL    = 'url';
    const TARGET_SELF   = 'self';
    
    const ENTRY_TOURS_OVERVIEW       = 'tours';
    const ENTRY_TOUR_FINDER          = 'tour_finder';
    const ENTRY_TOUR_DETAILS         = 'tour_details';
    const ENTRY_TOUR_BOOKING         = 'tour';
    const ENTRY_TOUR_VOUCHER_BOOKING = 'tour_vouchers';
    const ENTRY_SHOP                 = 'shop';
    
    const BUTTON_TYPE_LOGO = 'logo';
    const BUTTON_TYPE_TEXT = 'button';
    
    const BUTTON_LOGO_PATH = '/widget/book-logo.png';
    const BUTTON_TEXT_PATH = '/widget/book-button.png';
    
    
    /**
     * @param array $options
     * @return string
     */
    public function generateShortTag(array $options = array())
    {
        $options += $this->getDefaultOptions();
        $params = $this->getEntryPointParams($options['type'], $options, false);

        $settings = array_map(
            function($key, $value) {
                return $key . '="' . $value . '"';
            },
            array_keys($params),
            array_values($params)
        );

        return '[trekksoft ' . join(' ', $settings) . ']';
    }


    /**
     * @param string $host
     * @param array $options
     * @return string
     * @throws \InvalidArgumentException
     */
    public function generateEmbedCode($host, array $options = array())
    {
        try {
            $options += $this->getDefaultOptions();
            $entryPoint = $options['type'];

            if (empty($host)) {
                throw new \InvalidArgumentException('Please provide the base URL.');
            }

            $baseUrl = '//' . trim($host, '/') . '/' . $options['language'];

            $targetUrl  = '#';
            $targetAttr = '';
            $code       = '';

            if ($options['target'] == self::TARGET_FANCY) {
                $tpl   = array();
                $tpl[] = 'var button = new TrekkSoft.Embed.Button();';
                $tpl[] = 'button';


                foreach ($this->getEntryPointParams($options['type'], $options) as $key => $value) {
                    $tpl[]  = '      .setAttrib("' . $key . '", %s)';
                    $args[] = json_encode($value);
                }

                $tpl[]  = '      .registerOnClick("#%s");';
                $args[] = $options['element_id'];

                $code = $this->wrapJavaScriptCode(vsprintf(join(PHP_EOL, $tpl), $args), $baseUrl);
            } else {
                $targetUrl = $baseUrl . $this->getEntryPointURLPathWithQueryParams($entryPoint, $options);

                if ($options['target'] === self::TARGET_SELF) {
                    $targetAttr = ' target="_self"';
                } elseif ($options['target'] === self::TARGET_WINDOW) {
                    $targetAttr = ' target="_blank"';
                } elseif ($options['target'] === self::TARGET_URL) {
                    return $targetUrl;
                }
            }

            $buttonUrl = $baseUrl
                       . ($options['button_type'] == self::BUTTON_TYPE_LOGO ? self::BUTTON_LOGO_PATH : self::BUTTON_TEXT_PATH)
                       . '?caption=' . urlencode($options['button_label']);

            if (!empty($options['button_fg_color'])) {
                $buttonUrl .= '&foreColor=' . substr($options['button_fg_color'], 1);
            }

            if (!empty($options['button_bg_color'])) {
                $buttonUrl .= '&backColor=' . substr($options['button_bg_color'], 1);
            }

        } catch (\Exception $e) {
            return '<b>Widget Integration Problem</b>: '.$e->getMessage();
        }

        return sprintf(
            '<a' . $targetAttr . ' href="%s" id="%s"><img src="%s" alt="%s" title="%s" border="0" /></a>%s',
            $targetUrl,
            $options['element_id'],
            $buttonUrl,
            $options['button_label'],
            $options['button_label'],
            PHP_EOL . PHP_EOL . $code
        );
    }


    /**
     * @return array
     */
    public function getDefaultOptions()
    {
        return array(
            'element_id'       => $this->generateUniqueElementId(),
            'type'             => self::ENTRY_TOURS_OVERVIEW,
            'language'         => 'en',
            'target'           => self::TARGET_FANCY,
            'tour_id'          => 0,
            'group_id'         => 0,
            'category_id'      => 0,
            'referral'         => '',
            'button_label'     => 'Book Now',
            'button_type'      => self::BUTTON_TYPE_TEXT,
            'button_bg_color'  => null,
            'button_fg_color'  => null,
        );
    }


    /**
     * @param string $entryPoint
     * @param array $options
     * @return string
     * @throws \InvalidArgumentException
     */
    private function getEntryPointURLPathWithQueryParams($entryPoint, array $options)
    {
        switch ($entryPoint)
        {
            case self::ENTRY_TOURS_OVERVIEW       : $url = '/widget/tours/list';            break;
            case self::ENTRY_TOUR_FINDER          : $url = '/widget/tours/finder';          break;
            case self::ENTRY_SHOP                 : $url = '/widget/shop';                  break;
            case self::ENTRY_TOUR_DETAILS         : $url = '/widget/tours/';                break;
            case self::ENTRY_TOUR_BOOKING         : $url = '/widget/tours/book/';           break;
            case self::ENTRY_TOUR_VOUCHER_BOOKING : $url = '/widget/tours/book-vouchers/';  break;
            default: throw new \InvalidArgumentException("Unsupported entry point '$entryPoint'.");
        }

        $params = $this->getEntryPointParams($entryPoint, $options);
        unset($params['target'], $params['entryPoint']);

        return $url . '?' . http_build_query($params, '=', '&amp;');
    }


    /**
     * Checks and returns all params that were configured for the given entry point type.
     *
     * @param string $entryPoint
     * @param array $options
     * @return array
     * @throws \InvalidArgumentException
     */
    private function getEntryPointParams($entryPoint, array $options, $useMapping=true)
    {
        $required = array('target', 'type');
        $optional = array(
            'referral',
            'button_label',
            'button_type',
            'button_bg_color',
            'button_fg_color'
        );

        switch ($entryPoint)
        {
            case self::ENTRY_TOUR_FINDER:
                break;

            case self::ENTRY_SHOP:
                $optional[] = 'category_id';
                break;

            case self::ENTRY_TOUR_DETAILS:
            case self::ENTRY_TOUR_BOOKING:
            case self::ENTRY_TOUR_VOUCHER_BOOKING:
                $required[] = 'tour_id';
                break;

            case self::ENTRY_TOURS_OVERVIEW:
            default:
                $optional[] = 'group_id';
                $entryPoint = self::ENTRY_TOURS_OVERVIEW;
        }

        $options['type'] = $entryPoint;
        foreach ($required as $key) {
            if (empty($options[$key])) {
                throw new \InvalidArgumentException("The option '$key' is required for the entry point '$entryPoint'.");
            }
        }


        $allParams = array_merge($required, $optional);
        $filteredParams = array();

        if ($useMapping) {
            // This is the mapping that is used to set the params used by the API endpoint
            $mapping = array(
                'target'           => 'target',
                'type'             => 'entryPoint',
                'group_id'         => 'tourGroupId',
                'category_id'      => 'categoryId',
                'tour_id'          => 'tourId',
                'referral'         => 'referral',
            );

            foreach ($allParams as $key) {
                if (!empty($options[$key]) && isset($mapping[$key])) {
                    $filteredParams[$mapping[$key]] = $options[$key];
                }
            }
        } else {
            foreach ($allParams as $key) {
                if (!empty($options[$key])) {
                    $filteredParams[$key] = $options[$key];
                }
            }
        }

        return $filteredParams;
    }
    

    /**
     * @param string $code
     * @param string $baseUrl
     * @return string
     */
    private function wrapJavaScriptCode($code, $baseUrl)
    {
        $tpl = array(
            '<script src="%s"></script>',
            '<script>',
            '    (function() {',
            '%s',
            '    })();',
            '</script>',
        );
        
        $lines = array();
        foreach (explode(PHP_EOL, $code) as $line) {
            $lines[] = "        $line";
        }

        return sprintf(
            join(PHP_EOL, $tpl),
            $baseUrl . self::ENDPOINT_PATH,
            join(PHP_EOL, $lines)
        );
    }
    

    /**
     * @return string
     */
    private function generateUniqueElementId()
    {
        return 'trekksoft_' . mt_rand(1000, 9999);
    }
}