import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import Flyerbox from './Flyerbox';
import { StorybookData } from './index.data';

const meta: Meta<typeof Flyerbox> = {
  title: 'Shared/Atoms/Flyerbox',
  component: Flyerbox,
};
export default meta;
type Story = StoryObj<typeof Flyerbox>;
export const Primary: Story = {
  render: () => <Flyerbox data={StorybookData} />,
};
