import type { Meta, StoryObj } from '@storybook/react';
import BackToTop from './index';
import { StorybookData } from './index.data';

const meta: Meta<typeof BackToTop> = {
  title: 'Shared/Atoms/BackToTop',
  component: BackToTop,
};
export default meta;
type Story = StoryObj<typeof BackToTop>;
export const Primary: Story = {
  render: () => <BackToTop onClick={() => alert('wird geschlossen')} label={StorybookData.label} />,
};
