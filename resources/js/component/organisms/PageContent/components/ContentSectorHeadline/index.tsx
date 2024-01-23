import React from 'react';
import { ContentHeadlineProps } from '../../../../../props/props';
import ContentRow from '../ContentRow';

const ContentSectorHeadline: React.FC<React.PropsWithChildren<ContentHeadlineProps>> = (
  props: ContentHeadlineProps,
): JSX.Element => (
  <ContentRow>
    <h2 className="underline">{props.children}</h2>
  </ContentRow>
);
export default ContentSectorHeadline;
