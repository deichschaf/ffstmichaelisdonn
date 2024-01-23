import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import FireDepartmentManagement from './index';
import { StorybookData } from './index.data';

const meta: Meta<typeof FireDepartmentManagement> = {
  title: 'Fire/Organisms/FireDepartmentManagement',
  component: FireDepartmentManagement,
};
export default meta;
type Story = StoryObj<typeof FireDepartmentManagement>;
export const Primary: Story = {
  render: () => <FireDepartmentManagement data={StorybookData} />,
};
