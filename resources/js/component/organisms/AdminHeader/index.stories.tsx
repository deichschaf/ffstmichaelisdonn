import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import AdminHeader from './index';

const meta: Meta<typeof AdminHeader> = {
  title: 'Shared/Organisms/AdminHeader',
  component: AdminHeader,
};
export default meta;
type Story = StoryObj<typeof AdminHeader>;
export const Primary: Story = {
  render: () => <AdminHeader />,
};
