import type { Meta, StoryObj } from '@storybook/react';
import BlackdayMessage from './index';
import { StorybookData } from './index.data';

const meta: Meta<typeof BlackdayMessage> = {
  title: 'Shared/Atoms/BlackdayMessage',
  component: BlackdayMessage,
};
export default meta;
type Story = StoryObj<typeof BlackdayMessage>;
export const Primary: Story = {
  render: () => <BlackdayMessage data={StorybookData} />,
};
