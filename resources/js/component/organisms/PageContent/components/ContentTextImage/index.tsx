import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentTextImageProps } from '../../../../../props/props';
import ErrorBoundary from '../../../errorboundary';
import ContentChanger from './modules/ContentChanger';
import ContentTextLeft from './modules/ContentTextLeft';
import ContentTextRight from './modules/ContentTextRight';

const ContentTextImage: React.FC<React.PropsWithChildren<ContentTextImageProps>> = (
  props: ContentTextImageProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.page_content_images === 'undefined') {
    return <></>;
  }
  const { data } = props;

  const values = [];
  Object.values(data.page_content_images).map((value, idx) => values.push(value as never));

  return (
    <ErrorBoundary>
      {values.map((item, idx) => (
        <ContentChanger data={item} key={idx} idx={idx} />
      ))}
    </ErrorBoundary>
  );
};
export default ContentTextImage;
