import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import AdminHeadline from './index';

const meta: Meta<typeof AdminHeadline> = {
  title: 'Shared/Molecules/AdminHeadline',
  component: AdminHeadline,
};
export default meta;
type Story = StoryObj<typeof AdminHeadline>;
export const Primary: Story = {
  render: () => <AdminHeadline label="Testüberschrift" />,
};
