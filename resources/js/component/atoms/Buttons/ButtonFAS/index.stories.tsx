import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import ButtonFAS from './index';

const meta: Meta<typeof ButtonFAS> = {
  title: 'Shared/Atoms/ButtonFAS',
  component: ButtonFAS,
};
export default meta;
type Story = StoryObj<typeof ButtonFAS>;
export const Primary: Story = {
  render: () => <ButtonFAS className="times" />,
};
