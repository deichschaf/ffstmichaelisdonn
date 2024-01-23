import React from 'react';
import I from '../../atoms/Icon/I';
import H3 from '../../atoms/Typography/H3';
import ErrorBoundary from '../../organisms/errorboundary';

export interface DownloadsProps {
  download?: unknown;
}

function getDownloads(download: any) {
  const down = [...download];
  const list = down.map((item, idx) => (
    <li key={idx} className="download_list">
      <a href={item.link} target="_blank" rel="noreferrer">
        <I className={item.icon} /> {item.title} ({item.size})
      </a>
    </li>
  ));
  return <ul className="downloads">{list}</ul>;
}

const Downloads: React.FC<React.PropsWithChildren<DownloadsProps>> = (
  props: DownloadsProps,
): JSX.Element => (
  <ErrorBoundary>
    <div className="Downloads">
      <H3 label="Downloads" />
      <ErrorBoundary>{getDownloads(props.download)}</ErrorBoundary>
    </div>
  </ErrorBoundary>
);

export default Downloads;
