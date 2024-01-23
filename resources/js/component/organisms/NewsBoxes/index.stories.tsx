import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import NewsBoxes from './index';

const meta: Meta<typeof NewsBoxes> = {
  title: 'Shared/Organisms/NewsBoxes',
  component: NewsBoxes,
};
export default meta;
type Story = StoryObj<typeof NewsBoxes>;
export const Primary: Story = {
  render: () => <NewsBoxes />,
};
