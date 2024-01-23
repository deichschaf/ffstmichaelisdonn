import type { Meta, StoryObj } from '@storybook/react';
import Breadcrumb from './index';

const meta: Meta<typeof Breadcrumb> = {
  title: 'Shared/Atoms/Breadcrumb',
  component: Breadcrumb,
};
export default meta;
type Story = StoryObj<typeof Breadcrumb>;
export const Primary: Story = {
  render: () => <Breadcrumb />,
};
