import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import TermineVorbehalt from './index';

const meta: Meta<typeof TermineVorbehalt> = {
  title: 'Shared/Atoms/Corona/TermineVorbehalt',
  component: TermineVorbehalt,
};
export default meta;
type Story = StoryObj<typeof TermineVorbehalt>;
export const Primary: Story = {
  render: () => <TermineVorbehalt />,
};
