<?php

class SiteMeta
{
    private $siteUrl = 'https://portal-home-aiyouxi.com.cn';
    private $siteName = '爱游戏';
    private $keywords = ['爱游戏', '游戏资讯', '游戏评测', '游戏攻略'];
    private $description = '';
    private $author = '爱游戏团队';
    private $creationDate = '2024-01-01';
    private $version = '1.0.0';
    private $tags = [];

    public function __construct()
    {
        $this->description = $this->generateDefaultDescription();
        $this->tags = $this->keywords;
    }

    private function generateDefaultDescription()
    {
        $baseDesc = sprintf(
            '%s 是专注于游戏领域的综合平台，提供最新游戏资讯、专业评测和实用攻略。',
            $this->siteName
        );
        return $baseDesc;
    }

    public function setCustomDescription($desc)
    {
        $this->description = htmlspecialchars($desc, ENT_QUOTES, 'UTF-8');
    }

    public function addKeyword($keyword)
    {
        $cleanKeyword = htmlspecialchars(trim($keyword), ENT_QUOTES, 'UTF-8');
        if (!empty($cleanKeyword) && !in_array($cleanKeyword, $this->keywords)) {
            $this->keywords[] = $cleanKeyword;
            $this->tags[] = $cleanKeyword;
        }
    }

    public function getShortDescription($maxLength = 150)
    {
        $base = sprintf(
            '%s - %s',
            $this->siteName,
            $this->description
        );

        if (mb_strlen($base) > $maxLength) {
            $base = mb_substr($base, 0, $maxLength - 3) . '...';
        }

        return htmlspecialchars($base, ENT_QUOTES, 'UTF-8');
    }

    public function getMetaArray()
    {
        return [
            'site_url' => $this->siteUrl,
            'site_name' => $this->siteName,
            'description' => $this->description,
            'keywords' => implode(', ', $this->keywords),
            'author' => $this->author,
            'creation_date' => $this->creationDate,
            'version' => $this->version,
            'tags' => $this->tags,
        ];
    }

    public function getHtmlMetaTags()
    {
        $meta = $this->getMetaArray();
        $html = '';

        $html .= '<meta name="description" content="' . htmlspecialchars($meta['description'], ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<meta name="keywords" content="' . htmlspecialchars($meta['keywords'], ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<meta name="author" content="' . htmlspecialchars($meta['author'], ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<link rel="canonical" href="' . htmlspecialchars($meta['site_url'], ENT_QUOTES, 'UTF-8') . '">' . "\n";

        return $html;
    }

    public function displaySiteInfo()
    {
        $info = $this->getMetaArray();
        echo "站点名称: " . htmlspecialchars($info['site_name']) . "\n";
        echo "站点URL: " . htmlspecialchars($info['site_url']) . "\n";
        echo "简短描述: " . $this->getShortDescription() . "\n";
    }
}

// 示例用法
$siteMeta = new SiteMeta();
$siteMeta->addKeyword('手机游戏');
$siteMeta->addKeyword('PC游戏');
$siteMeta->setCustomDescription('爱游戏为您带来最全面的游戏资讯和深度评测，让您不错过任何一款好游戏。');

$siteMeta->displaySiteInfo();

echo "\n--- HTML Meta Tags ---\n";
echo $siteMeta->getHtmlMetaTags();