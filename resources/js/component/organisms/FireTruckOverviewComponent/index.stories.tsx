import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import FireTruckOverviewComponent from './index';

const meta: Meta<typeof FireTruckOverviewComponent> = {
  title: 'Fire/Organisms/FireTruckOverviewComponent',
  component: FireTruckOverviewComponent,
};
export default meta;
type Story = StoryObj<typeof FireTruckOverviewComponent>;
export const Primary: Story = {
  render: () => <FireTruckOverviewComponent />,
};
