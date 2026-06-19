<?php
/**
 * 站点元信息配置与描述生成工具
 * 用于管理和生成站点的简短描述文本
 */

class SiteMeta {
    private array $siteName;
    private array $keywords;
    private array $descriptions;
    private array $urls;
    private array $extraInfo;

    public function __construct() {
        $this->siteName = [
            'primary' => '乐鱼体育',
            'secondary' => '乐鱼体育官方平台',
            'short' => '乐鱼'
        ];

        $this->keywords = [
            '体育赛事',
            '乐鱼体育',
            '在线体育',
            '运动资讯',
            '体育直播'
        ];

        $this->descriptions = [
            '乐鱼体育为您提供最新体育资讯和赛事信息',
            '专业的体育在线平台，乐鱼体育与您共享运动激情',
            '乐鱼体育，精彩赛事一网打尽'
        ];

        $this->urls = [
            'main' => 'https://mleyusports.com.cn',
            'about' => 'https://mleyusports.com.cn/about',
            'contact' => 'https://mleyusports.com.cn/contact'
        ];

        $this->extraInfo = [
            'version' => '1.2.0',
            'language' => 'zh-CN',
            'charset' => 'UTF-8'
        ];
    }

    /**
     * 生成简要描述文本
     * @param string $type 描述类型：short, normal, full
     * @return string
     */
    public function generateDescription(string $type = 'normal'): string {
        $baseDesc = $this->descriptions[array_rand($this->descriptions)];

        switch ($type) {
            case 'short':
                return $this->siteName['primary'] . ' - ' . $this->keywords[0];
            case 'full':
                $keywordStr = implode('、', array_slice($this->keywords, 0, 3));
                return $baseDesc . '。关键词：' . $keywordStr . '。访问 ' . $this->urls['main'];
            case 'normal':
            default:
                return $baseDesc . ' | ' . $this->urls['main'];
        }
    }

    /**
     * 获取格式化后的站点元数据
     * @return array
     */
    public function getMetaData(): array {
        return [
            'title' => $this->siteName['primary'],
            'description' => $this->generateDescription('full'),
            'keywords' => implode(',', $this->keywords),
            'url' => $this->urls['main'],
            'extra' => $this->extraInfo
        ];
    }

    /**
     * 输出HTML友好的描述标签
     * @return string
     */
    public function renderMetaTags(): string {
        $meta = $this->getMetaData();
        $output = '';

        $output .= '<meta name="description" content="' . htmlspecialchars($meta['description'], ENT_QUOTES, 'UTF-8') . '" />' . "\n";
        $output .= '<meta name="keywords" content="' . htmlspecialchars($meta['keywords'], ENT_QUOTES, 'UTF-8') . '" />' . "\n";
        $output .= '<link rel="canonical" href="' . htmlspecialchars($meta['url'], ENT_QUOTES, 'UTF-8') . '" />' . "\n";

        return $output;
    }

    /**
     * 获取所有可用描述类型
     * @return array
     */
    public function getAvailableDescriptions(): array {
        $descriptions = [];
        $types = ['short', 'normal', 'full'];

        foreach ($types as $type) {
            $descriptions[$type] = $this->generateDescription($type);
        }

        return $descriptions;
    }
}

// 示例使用
$meta = new SiteMeta();

echo "=== 站点描述示例 ===\n";
echo "简短描述: " . $meta->generateDescription('short') . "\n";
echo "标准描述: " . $meta->generateDescription('normal') . "\n";
echo "完整描述: " . $meta->generateDescription('full') . "\n\n";

echo "=== HTML Meta标签 ===\n";
echo $meta->renderMetaTags() . "\n";

echo "=== 所有描述类型 ===\n";
print_r($meta->getAvailableDescriptions());

echo "\n=== 完整元数据 ===\n";
print_r($meta->getMetaData());