import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { PageOverviewRootListProps } from '../../../props/props';
import PageOverviewRoot from './PageOverviewRoot';
import PageOverviewSecond from './PageOverviewSecond';

const PageOverviewRootList: React.FC<React.PropsWithChildren<PageOverviewRootListProps>> = (
  props: PageOverviewRootListProps,
): JSX.Element => (
  <ErrorBoundary>
    <div className="pageList">
      {Object.values(props.pages).map((item: any, idx) => (
        <PageOverviewRoot
          key={idx}
          page={item.page}
          upages={item.upage}
          deletepath={props.deletepath}
          editpath={props.editpath}
          editheadlinepath={props.editheadlinepath}
          pagecontenttypes={props.pagecontenttypes}
        />
      ))}
    </div>
  </ErrorBoundary>
);
export default PageOverviewRootList;
