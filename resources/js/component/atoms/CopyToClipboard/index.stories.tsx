import React from 'react';
import type { Meta, StoryObj } from '@storybook/react';
import CopyToClipboard from './CopyToClipboard';

const meta: Meta<typeof CopyToClipboard> = {
  title: 'Shared/Atoms/CopyToClipboard',
  component: CopyToClipboard,
};
export default meta;
type Story = StoryObj<typeof CopyToClipboard>;
export const Primary: Story = {
  render: () => <CopyToClipboard content="Text zum kopieren, in die Zwischenablage" />,
};
