import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import DanceBall from './index';
import { StorybookData } from './index.data';

const meta: Meta<typeof DanceBall> = {
  title: 'Shared/Atoms/DanceBall',
  component: DanceBall,
};
export default meta;
type Story = StoryObj<typeof DanceBall>;
export const Primary: Story = {
  render: () => <DanceBall data={StorybookData} />,
};
