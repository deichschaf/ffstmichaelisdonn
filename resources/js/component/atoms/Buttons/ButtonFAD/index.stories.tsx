import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import ButtonFAD from './index';

const meta: Meta<typeof ButtonFAD> = {
  title: 'Shared/Atoms/ButtonFAD',
  component: ButtonFAD,
};
export default meta;
type Story = StoryObj<typeof ButtonFAD>;
export const Primary: Story = {
  render: () => <ButtonFAD className="times" />,
};
