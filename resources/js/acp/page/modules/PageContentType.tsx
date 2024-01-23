import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { PageContentTypeProps } from '../../../props/props';

const PageContentType: React.FC<React.PropsWithChildren<PageContentTypeProps>> = (
  props: PageContentTypeProps,
): JSX.Element => {
  const contentTypeId = props.contentTypeId as number;
  const contentType = props.contentType as string;
  return (
    <ErrorBoundary>
      <span className="content_types">
        <img
          src={`/grfx/icons/${props.pagecontenttypes[contentTypeId].image}`}
          alt={props.pagecontenttypes[contentTypeId].content_title}
          title={props.pagecontenttypes[contentTypeId].content_title}
          className="page_content_types"
        />
      </span>
    </ErrorBoundary>
  );
};
export default PageContentType;
