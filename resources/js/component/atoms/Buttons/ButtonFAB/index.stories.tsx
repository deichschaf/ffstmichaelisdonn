import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import ButtonFAB from './index';

const meta: Meta<typeof ButtonFAB> = {
  title: 'Shared/Atoms/ButtonFAB',
  component: ButtonFAB,
};
export default meta;
type Story = StoryObj<typeof ButtonFAB>;
export const Primary: Story = {
  render: () => <ButtonFAB className="times" />,
};
