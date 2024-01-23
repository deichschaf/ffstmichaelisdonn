import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import BackToTop from './index';

const meta: Meta<typeof BackToTop> = {
  title: 'Shared/Organisms/BackToTop',
  component: BackToTop,
};
export default meta;
type Story = StoryObj<typeof BackToTop>;
export const Primary: Story = {
  render: () => <BackToTop />,
};
