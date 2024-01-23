import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import CriticalMessage from './index';

const meta: Meta<typeof CriticalMessage> = {
  title: 'Shared/Atoms/CriticalMessage',
  component: CriticalMessage,
};
export default meta;
const data = {
  msgType: '',
  event: '',
  headline: '',
  description: '',
  sender: '',
  send: '',
};
type Story = StoryObj<typeof CriticalMessage>;
export const Primary: Story = {
  render: () => <CriticalMessage data={data} />,
};
