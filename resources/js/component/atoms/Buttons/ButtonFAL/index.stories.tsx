import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import ButtonFAL from './index';

const meta: Meta<typeof ButtonFAL> = {
  title: 'Shared/Atoms/ButtonFAL',
  component: ButtonFAL,
};
export default meta;
type Story = StoryObj<typeof ButtonFAL>;
export const Primary: Story = {
  render: () => <ButtonFAL className="times" />,
};
