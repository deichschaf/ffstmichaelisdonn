import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import Header from './index';

const meta: Meta<typeof Header> = {
  title: 'Shared/Organisms/Header',
  component: Header,
};
export default meta;
type Story = StoryObj<typeof Header>;
export const Primary: Story = {
  render: () => <Header />,
};
