import { useTheme } from '../contexts/ThemeContext';
import HeroBlock from './blocks/HeroBlock';
import TextBlock from './blocks/TextBlock';
import ImageBlock from './blocks/ImageBlock';
import GalleryBlock from './blocks/GalleryBlock';
import CtaBlock from './blocks/CtaBlock';
import FeaturesBlock from './blocks/FeaturesBlock';
import TestimonialsBlock from './blocks/TestimonialsBlock';
import StatsBlock from './blocks/StatsBlock';
import ContactBlock from './blocks/ContactBlock';
import NewsletterBlock from './blocks/NewsletterBlock';
import VideoBlock from './blocks/VideoBlock';
import AccordionBlock from './blocks/AccordionBlock';
import TabsBlock from './blocks/TabsBlock';
import CardsBlock from './blocks/CardsBlock';
import BannerBlock from './blocks/BannerBlock';
import DividerBlock from './blocks/DividerBlock';

const blockComponents = {
    hero: HeroBlock,
    text: TextBlock,
    image: ImageBlock,
    gallery: GalleryBlock,
    cta: CtaBlock,
    features: FeaturesBlock,
    testimonials: TestimonialsBlock,
    stats: StatsBlock,
    contact: ContactBlock,
    newsletter: NewsletterBlock,
    video: VideoBlock,
    accordion: AccordionBlock,
    tabs: TabsBlock,
    cards: CardsBlock,
    banner: BannerBlock,
    divider: DividerBlock,
};

function DynamicContentRenderer({ contentBlocks = [], pageSettings = {}, template = 'default' }) {
    const { isDark } = useTheme();

    // Convert contentBlocks to array if it's an object
    const blocksArray = Array.isArray(contentBlocks) 
        ? contentBlocks 
        : Object.values(contentBlocks || {});

    if (!blocksArray || blocksArray.length === 0) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <div className="text-center">
                    <h2 className="text-2xl font-bold text-gray-600 mb-4">No Content</h2>
                    <p className="text-gray-500">This page doesn't have any content blocks yet.</p>
                </div>
            </div>
        );
    }

    return (
        <div className={`dynamic-content template-${template} ${
            isDark ? 'dark' : 'light'
        }`}>
            {blocksArray.map((block, index) => {
                const BlockComponent = blockComponents[block.type];
                
                if (!BlockComponent) {
                    console.warn(`Unknown block type: ${block.type}`);
                    return (
                        <div key={index} className="p-4 bg-yellow-100 border border-yellow-400 rounded-lg m-4">
                            <p className="text-yellow-800">
                                Unknown block type: {block.type}
                            </p>
                        </div>
                    );
                }

                return (
                    <BlockComponent
                        key={block.id || index}
                        data={block.data || {}}
                        settings={block.settings || {}}
                        pageSettings={pageSettings}
                        index={index}
                    />
                );
            })}
        </div>
    );
}

export default DynamicContentRenderer;
