import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import DireStraits from './index';

const meta: Meta<typeof DireStraits> = {
  title: 'Shared/Atoms/DireStraits',
  component: DireStraits,
};
export default meta;
type Story = StoryObj<typeof DireStraits>;
export const Primary: Story = {
  render: () => <DireStraits />,
};
