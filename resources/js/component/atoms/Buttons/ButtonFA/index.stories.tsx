import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import ButtonFA from './index';

const meta: Meta<typeof ButtonFA> = {
  title: 'Shared/Atoms/ButtonFA',
  component: ButtonFA,
};
export default meta;
type Story = StoryObj<typeof ButtonFA>;
export const Primary: Story = {
  render: () => <ButtonFA className="times" />,
};
