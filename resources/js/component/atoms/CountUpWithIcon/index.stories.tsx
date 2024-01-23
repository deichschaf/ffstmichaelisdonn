import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import CountUpWithIcon from './index';

const meta: Meta<typeof CountUpWithIcon> = {
  title: 'Shared/Atoms/CountUpWithIcon',
  component: CountUpWithIcon,
};
export default meta;
type Story = StoryObj<typeof CountUpWithIcon>;
export const Primary: Story = {
  render: () => <CountUpWithIcon startcount={0} maxcount={10} icontype="fas" icon="clock" />,
};
