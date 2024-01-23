import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import CoronaTermine from './index';

const meta: Meta<typeof CoronaTermine> = {
  title: 'Shared/Atoms/Corona/Termine',
  component: CoronaTermine,
};
export default meta;
type Story = StoryObj<typeof CoronaTermine>;
export const Primary: Story = {
  render: () => <CoronaTermine />,
};
