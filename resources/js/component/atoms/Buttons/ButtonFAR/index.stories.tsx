import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import ButtonFAR from './index';

const meta: Meta<typeof ButtonFAR> = {
  title: 'Shared/Atoms/ButtonFAR',
  component: ButtonFAR,
};
export default meta;
type Story = StoryObj<typeof ButtonFAR>;
export const Primary: Story = {
  render: () => <ButtonFAR className="times" />,
};
